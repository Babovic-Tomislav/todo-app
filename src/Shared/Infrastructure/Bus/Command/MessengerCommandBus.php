<?php

namespace Shared\Infrastructure\Bus\Command;

use Shared\Application\Command\CommandBusInterface;
use Shared\Application\Command\CommandInterface;
use Shared\Infrastructure\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws \Throwable
     */
    public function handle(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
