<?php

declare(strict_types=1);

namespace Shared\Application\Result;

class Set
{
    /** @param mixed[] $results */
    public function __construct(protected int $totalResults, protected array $results)
    {
    }

    public function getTotalResults(): int
    {
        return $this->totalResults;
    }

    /**
     * @return mixed[]
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
