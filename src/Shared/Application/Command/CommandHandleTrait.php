<?php

namespace Shared\Application\Command;

trait CommandHandleTrait
{
    private CommandBusInterface $commandBus;

    public function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }
}
