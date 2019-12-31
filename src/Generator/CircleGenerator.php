<?php

declare(strict_types=1);

namespace CIConfigGen\Generator;

use CIConfigGen\Contract\GeneratorInterface;
use CIConfigGen\ScriptFactory\PHPUnitScriptFactory;
use CIConfigGen\ValueObject\CiService;

final class CircleGenerator implements GeneratorInterface
{
    /**
     * @var PHPUnitScriptFactory
     */
    private $phpUnitScriptFactory;

    public function __construct(PHPUnitScriptFactory $phpUnitScriptFactory)
    {
        $this->phpUnitScriptFactory = $phpUnitScriptFactory;
    }

    public function isMatch(string $ciService): bool
    {
        return $ciService === CiService::CIRCLE_CI;
    }

    public function generate(array $composerJson): array
    {
        return [
            'name' => CiService::CIRCLE_CI,
            'language' => 'PHP',
            'on' => '[push]',
            'jobs' => [
                'test' => [
                    'name' => 'PhpUnit',
                    'script' => $this->phpUnitScriptFactory->create(),
                ],
            ],
        ];
    }

    public function getFilename(): string
    {
        return '.circleci/config.yml';
    }
}
