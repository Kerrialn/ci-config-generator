
# CI Generate

![Github Actions](https://github.com/Kerrialn/ci-gen/workflows/Github%20Actions/badge.svg)
[![Travis Status](https://img.shields.io/travis/kerrialn/ci-gen/master.svg?style=flat-square)](https://travis-ci.org/kerrialn/ci-gen)
[![Downloads](https://img.shields.io/packagist/dt/kerrialn/ci-gen.svg?style=flat-square)](https://packagist.org/packages/kerrialn/ci-gen)


#### Blurb 
Automatically generate the configuration yaml file for continuous integration (CI) services. Never write a CI yaml file manually again!

#### Use cases
- Setting up a project and want  to use a CI service
- Switching CI services and don't want the hassle of rewriting your yaml file to be compatible with the new service (not yet implemented) 

#### Run process
1. Install: `composer require kerrialn/ci-gen`
1. Run: `bin/console generate`
2. Select CI service you want to use 
3. Done

#### CI Services Compatibility
- Travis CI
- Github Actions