<?php

declare(strict_types=1);

namespace App\Utils;

use Symplify\MonorepoBuilder\ComposerJsonObject\ValueObject\ComposerJson;
use Symplify\MonorepoBuilder\FileSystem\JsonFileManager;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ComposerJsonFactory
{
    private const COMPOSER_JSON_PATH = __DIR__ . '/../../composer.json';
    private JsonFileManager $jsonFileManager;

    public function __construct(JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }

    public function createFromFileInfo(SmartFileInfo $smartFileInfo): ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($smartFileInfo->getRealPath());

        return $this->createFromArray($jsonArray);
    }

    public function createFromFilePath(string $filePath): ComposerJson
    {
        $jsonArray = $this->jsonFileManager->loadFromFilePath($filePath);

        return $this->createFromArray($jsonArray);
    }


    public function createFromArray(array $jsonArray): ComposerJson
    {
        $composerJson = new ComposerJson();

        if (isset($jsonArray['name'])) {
            $composerJson->setName($jsonArray['name']);
        }

        if (isset($jsonArray['require'])) {
            $composerJson->setRequire($jsonArray['require']);
        }

        if (isset($jsonArray['require-dev'])) {
            $composerJson->setRequireDev($jsonArray['require-dev']);
        }

        if (isset($jsonArray['autoload'])) {
            $composerJson->setAutoload($jsonArray['autoload']);
        }

        if (isset($jsonArray['autoload-dev'])) {
            $composerJson->setAutoloadDev($jsonArray['autoload-dev']);
        }

        if (isset($jsonArray['replace'])) {
            $composerJson->setReplace($jsonArray['replace']);
        }

        if (isset($jsonArray['extra'])) {
            $composerJson->setExtra($jsonArray['extra']);
        }

        $orderedKeys = array_keys($jsonArray);
        $composerJson->setOrderedKeys($orderedKeys);

        // @todo the rest

        return $composerJson;
    }

    public function getComposerJson()
    {
        return $this->createFromFilePath(self::COMPOSER_JSON_PATH);
    }
}
