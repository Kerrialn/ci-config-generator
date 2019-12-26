<?php

namespace CIConfigGen\Generators;

use CIConfigGen\Contract\GeneratorsInterface;
use CIConfigGen\ValueObject\Constants;

class TravisGenerator implements GeneratorsInterface {

    public function isMatch(string $ciService): string
    {
        return $ciService === Constants::TRAVIS_CI;
    }

    public function generate(array $composerJson): array
    {
        return array(
            'name' => Constants::TRAVIS_CI,
            'matrix' => [
                'include' => [
                    ['php' => 7.2],
                    ['env' => 'COMPOSER_FLAGS="--prefer-lowest"'],
                    ['php' => 7.3],
                    ['php' => 7.4],
                ]
            ],
            'install' => [
                'composer update --prefer-source $COMPOSER_FLAGS'
            ],
            'script' => [
                'bin/ecs',
                'vendor/bin/phpunit'
            ],
            'notifications'=>[
                'email'=>false
            ]
        );
    }
}
