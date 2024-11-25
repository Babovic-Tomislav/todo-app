<?php

declare(strict_types=1);

namespace Shared\Domain\Pagination;

class PaginationData
{
    public function __construct(private ?int $limit, private int $offset)
    {
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
