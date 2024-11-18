<?php

namespace Shared\Application\Query;

trait QueryHandleTrait
{
    private QueryBusInterface $queryBus;

    public function ask(QueryInterface $query): mixed
    {
        return $this->queryBus->ask($query);
    }
}
