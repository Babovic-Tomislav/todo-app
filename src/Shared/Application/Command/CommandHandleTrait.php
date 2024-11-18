<?php

namespace Shared\Application\Command;

trait CommandHandleTrait
{
    private readonly CommandBusInterface $commandBus;

    public function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }
}
