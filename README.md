# object-dependencies-parser
[![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2Fjerowork%2Fobject-dependencies-parser%2Fbadge%3Fref%3Dmain&style=flat-square)](https://github.com/jerowork/object-dependencies-parser/actions)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jerowork/object-dependencies-parser.svg?style=flat-square)](https://scrutinizer-ci.com/g/jerowork/object-dependencies-parser/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jerowork/object-dependencies-parser.svg?style=flat-square)](https://scrutinizer-ci.com/g/jerowork/object-dependencies-parser)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/jerowork/object-dependencies-parser.svg?style=flat-square&include_prereleases)](https://packagist.org/packages/jerowork/object-dependencies-parser)
[![PHP Version](https://img.shields.io/badge/php-%5E8.2-8892BF.svg?style=flat-square)](http://www.php.net)

Parse all dependencies (FQN) used in an object (e.g. class, trait, interface).

## Installation
Install via [Composer](https://getcomposer.org/):

```bash
composer require jerowork/object-dependencies-parser
```

## Usage
```php
use Jerowork\ObjectDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ObjectDependenciesParser\PhpParser\PhpParserObjectDependenciesParser;
use PhpParser\ParserFactory;

// Setup parser
$parser = new PhpParserObjectDependenciesParser(
    (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
    new NodeTraverserFactory(),
);

// Parse file
$objectDependencies = $parser->parse('/Path/To/file.php');

// Output dependencies
print_r(
    $objectDependencies->getDependencyList(),
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
use Jerowork\ObjectDependenciesParser\ObjectDependenciesParser;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ObjectDependenciesParser\PhpParser\PhpParserObjectDependenciesParser;
use PhpParser\ParserFactory;

return [
    ObjectDependenciesParser::class => static function (ContainerInterface $container): ObjectDependenciesParser {
        return new PhpParserObjectDependenciesParser(
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

  Jerowork\ObjectDependenciesParser\ObjectDependenciesParser:
    class: Jerowork\ObjectDependenciesParser\PhpParser\PhpParserObjectDependenciesParser

  Jerowork\ObjectDependenciesParser\PhpParser\NodeTraverserFactory: ~

  PhpParser\ParserFactory: ~

  PhpParser\Parser:
    factory: ['@PhpParser\ParserFactory', 'create']
    arguments:
      $kind: 1
```
