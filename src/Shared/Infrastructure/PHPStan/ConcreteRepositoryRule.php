<?php

namespace Shared\Infrastructure\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Stmt\Class_>
 */
final class ConcreteRepositoryRule implements Rule
{
    public function __construct(
        private ReflectionProvider $reflectionProvider,
        private string $requiredSubInterface,
        private string $subClassOf,
    ) {
    }

    public function getNodeType(): string
    {
        return Node\Stmt\Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (null === $node->name) {
            return [];
        }

        $className = $scope->getNamespace().'\\'.$node->name->toString();

        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        if (!$classReflection->isSubclassOf($this->subClassOf)) {
            return [];
        }

        $interfaces = $classReflection->getImmediateInterfaces();

        foreach ($interfaces as $interface) {
            if ($interface->isSubclassOf($this->requiredSubInterface)) {
                return [];
            }
        }

        return [
            RuleErrorBuilder::message(sprintf(
                'Class %s must implement interface that extends %s.',
                $className,
                $this->requiredSubInterface
            ))->identifier('interface.implements')->build(),
        ];
    }
}
