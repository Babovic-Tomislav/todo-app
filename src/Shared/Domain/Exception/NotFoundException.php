<?php

namespace Shared\Domain\Exception;

final class NotFoundException extends \Exception
{
    private function __construct(string $message = '')
    {
        parent::__construct($message, 404);
    }

    /**
     * @param class-string $className
     */
    public static function becauseEntityNotFound(string $className, ?string $id = null): self
    {
        try {
            $shortClassName = (new \ReflectionClass($className))->getShortName();
        } catch (\ReflectionException $e) {
            $shortClassName = 'Entity';
        }

        if ($id !== null) {
            return new self(\sprintf('%s with ID = %s not found', $shortClassName, $id));
        }

        return new self(\sprintf('%s not found', $shortClassName));
    }
}
