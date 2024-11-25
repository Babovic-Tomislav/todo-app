<?php

declare(strict_types=1);

namespace Shared\Application\Result;

final class PaginatedSet extends Set
{
    public function __construct(
        private ?int $limit,
        private int $offset,
        protected int $totalResults,
        protected array $results,
    ) {
        parent::__construct($totalResults, $results);
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getPage(): int
    {
        return (int) floor($this->offset / $this->limit) + 1;
    }

    public function getPerPage(): ?int
    {
        return $this->limit;
    }

    public function getTotalPages(): int
    {
        return (int) floor($this->totalResults / $this->limit) + 1;
    }
}
