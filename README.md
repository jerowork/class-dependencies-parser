# class-dependencies-parser
[![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2Fjerowork%2Fclass-dependencies-parser%2Fbadge%3Fref%3Dmain&style=flat-square)](https://github.com/jerowork/class-dependencies-parser/actions)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jerowork/class-dependencies-parser.svg?style=flat-square)](https://scrutinizer-ci.com/g/jerowork/class-dependencies-parser/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jerowork/class-dependencies-parser.svg?style=flat-square)](https://scrutinizer-ci.com/g/jerowork/class-dependencies-parser)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/jerowork/class-dependencies-parser.svg?style=flat-square&include_prereleases)](https://packagist.org/packages/jerowork/class-dependencies-parser)
[![PHP Version](https://img.shields.io/badge/php-%5E8.1-8892BF.svg?style=flat-square)](http://www.php.net)

Parse all dependencies (FQN) used in a class (e.g. class, trait, interface, enum).

## Installation
Install via [Composer](https://getcomposer.org/):

```bash
composer require jerowork/class-dependencies-parser
```

## Usage
```php
use Jerowork\ClassDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ClassDependenciesParser\PhpParser\PhpParserClassDependenciesParser;
use PhpParser\ParserFactory;

// Setup parser
$parser = new PhpParserClassDependenciesParser(
    (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
    new NodeTraverserFactory(),
);

// Parse file
$classDependencies = $parser->parse('/Path/To/file.php');

// Output dependencies
print_r(
    $classDependencies->getDependencyList(),
);

// This will output e.g.:
[
    'Some/Namespace/Class',
    'Another/Namespace/Trait',
    // ...
]
```

## DI service definition

As a good practice we should always 'program to interfaces, not implementations', you should add this to your DI container.

PSR-11 Container example:
```php
use Jerowork\ClassDependenciesParser\ClassDependenciesParser;
use Jerowork\ClassDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ClassDependenciesParser\PhpParser\PhpParserClassDependenciesParser;
use PhpParser\ParserFactory;

return [
    ClassDependenciesParser::class => static function (ContainerInterface $container): ClassDependenciesParser {
        return new PhpParserClassDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );
    },
];
```
Symfony YAML-file example:
```yaml
services:
  _defaults:
    autowire: true
    autoconfigure: true

  Jerowork\ClassDependenciesParser\ClassDependenciesParser:
    class: Jerowork\ClassDependenciesParser\PhpParser\PhpParserClassDependenciesParser

  Jerowork\ClassDependenciesParser\PhpParser\NodeTraverserFactory: ~

  PhpParser\ParserFactory: ~

  PhpParser\Parser:
    factory: ['@PhpParser\ParserFactory', 'create']
    arguments:
      $kind: 1
```
