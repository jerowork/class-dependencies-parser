# object-dependencies-parser
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
