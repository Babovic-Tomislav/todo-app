<?php

namespace Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;

trait MessageBusExceptionTrait
{
    public function getException(HandlerFailedException $exception): \Throwable
    {
        while ($exception instanceof HandlerFailedException) {
            /** @var \Throwable $exception */
            $exception = $exception->getPrevious();
        }

        return $exception;
    }
}
