<?php

namespace Shared\Application\Command;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}
