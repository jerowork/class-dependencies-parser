<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ImportedFqn;
use PhpParser\Node\Name;

trait CreateInlineFqnBasedOnImportedFqnTrait
{
    public function createInlineFqnBasedOnImportedFqn(ImportedFqn $importedFqn, Name $name): ?Fqn
    {
        if (count($name->parts) === 1) {
            return null;
        }

        // Set importedFqn as non-class (folder namespace)
        $importedFqn->isNotClass();

        $nameParts = $name->parts;
        array_shift($nameParts);

        return new Fqn(sprintf('%s\%s', $importedFqn->fqn, implode('\\', $nameParts)));
    }
}
