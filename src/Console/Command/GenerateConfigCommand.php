<?php declare(strict_types=1);

namespace CIConfigGen\Console\Command;

use CIConfigGen\Contract\WorkerInterface;
use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;
use Symplify\PackageBuilder\Console\ShellCode;

final class GenerateConfigCommand extends Command
{
    /**
     * @var WorkerInterface[]
     */
    private $workers = [];

    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @param WorkerInterface[] $workers
     */
    public function __construct(array $workers, SymfonyStyle $symfonyStyle)
    {
        parent::__construct();
        $this->workers = $workers;
        $this->symfonyStyle = $symfonyStyle;
    }

    protected function configure(): void
    {
        $this->setName('craft:generate');
        $this->setDescription('Generate a yml file for continuous delivery & integration platforms');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $composerJsonFile = __DIR__ . '/../../../composer.json';

        $composerJsonContent = Json::decode(FileSystem::read($composerJsonFile), Json::FORCE_ARRAY);

        $ciYaml = [];
        foreach ($this->workers as $worker) {
            if (! $worker->isMatch($composerJsonContent)) {
                continue;
            }

            $ciYaml = $worker->decorate($composerJsonContent, $ciYaml);
        }

        $yaml = Yaml::dump($composerJsonContent, 2, 4, Yaml::DUMP_OBJECT_AS_MAP);
        FileSystem::write('example.yaml', $yaml);

        // @see https://symfony.com/blog/new-in-symfony-2-8-console-style-guide
        $this->symfonyStyle->success('Complete');

        return ShellCode::SUCCESS;
    }

}

