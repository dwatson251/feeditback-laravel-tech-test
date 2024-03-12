<?php

namespace App\Domain\Entity;

class PaginationCursor
{
    public function __construct(
        private ?string $current = null,
        private ?string $next = null,
        private ?string $previous = null,
    ) {}

    public function getCurrent(): ?string
    {
        return $this->current;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function getPrevious(): ?string
    {
        return $this->previous;
    }
}
