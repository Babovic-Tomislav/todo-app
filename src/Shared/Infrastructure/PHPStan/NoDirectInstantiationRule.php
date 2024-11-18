<?php

namespace Shared\Infrastructure\PHPStan;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<New_>
 */
readonly class NoDirectInstantiationRule implements Rule
{
    /**
     * @param string[] $allowedContexts
     */
    public function __construct(
        private string $restrictedClass,
        private array $allowedContexts,
        private ReflectionProvider $reflectionProvider,
    ) {
    }

    public function getNodeType(): string
    {
        return New_::class;
    }

    /**
     * @param New_ $node
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->class instanceof Node\Name) {
            $className = $scope->resolveName($node->class);
            if (!$this->reflectionProvider->hasClass($className)) {
                // Class does not exist; skip processing
                return [];
            }

            $classReflection = $this->reflectionProvider->getClass($className);
            // Check if the class extends the restricted base class
            if ($classReflection->isSubclassOf($this->restrictedClass)) {
                $classInContext = $scope->getClassReflection();

                if (!$classInContext) {
                    return [];
                }

                $classInContextInAllowedClasses = !empty(array_filter($this->allowedContexts,
                    function (string $allowedContext) use ($classInContext) {
                        return $classInContext->isSubclassOf($allowedContext);
                    }
                ));

                if (!$classInContextInAllowedClasses) {
                    return [
                        RuleErrorBuilder::message(\sprintf(
                            'New %s instance can be created only in %s.',
                            $className,
                            implode(',', $this->allowedContexts)
                        ))->identifier('direct.instantiation')->build(),
                    ];
                }
            }
        }

        return [];
    }
}
