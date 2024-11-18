<?php

namespace Shared\Infrastructure\Bus\Query;

use Shared\Application\Query\QueryBusInterface;
use Shared\Application\Query\QueryInterface;
use Shared\Infrastructure\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerQueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws \Throwable
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            $this->messageBus->dispatch($query);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }

        return true;
    }
}
