<?php

namespace Shared\Application\Query;

trait QueryHandleTrait
{
    private readonly QueryBusInterface $queryBus;

    public function ask(QueryInterface $query): mixed
    {
        return $this->queryBus->ask($query);
    }
}
