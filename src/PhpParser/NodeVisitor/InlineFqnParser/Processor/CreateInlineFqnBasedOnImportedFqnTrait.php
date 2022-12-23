<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ImportedFqn;
use PhpParser\Node\Name;

trait CreateInlineFqnBasedOnImportedFqnTrait
{
    public function createInlineFqnBasedOnImportedFqn(ImportedFqn $importedFqn, Name $name): ?Fqn
    {
        if (count($name->parts) === 1) {
            return null;
        }

        // Set importedFqn as non-object (folder namespace)
        $importedFqn->isNotObject();

        $nameParts = $name->parts;
        array_shift($nameParts);

        return new Fqn(sprintf('%s\%s', $importedFqn->fqn, implode('\\', $nameParts)));
    }
}
