<?php

namespace Storage\Doctrine\Entity\Traits;

use Carbon\Carbon;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait TimestampableEntityTrait
{
    #[
        Gedmo\Timestampable(on: 'create'),
        ORM\Column(type: Types::DATETIME_MUTABLE)
    ]
    protected Carbon $createdAt;

    #[
        Gedmo\Timestampable(on: 'update'),
        ORM\Column(type: Types::DATETIME_MUTABLE)
    ]
    protected Carbon $updatedAt;

    public function setCreatedAt(Carbon $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
