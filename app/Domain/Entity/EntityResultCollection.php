<?php
declare(strict_types=1);

namespace App\Domain\Entity;

/**
 * @template TValue
 * @template-implements \Iterator<int, TValue>
 */
class EntityResultCollection implements \Iterator
{
    private int $index = 0;

    /**
     * @param PaginationCursor $cursor
     * @param array $resultSubset
     */
    public function __construct(
        private PaginationCursor $cursor,
        private array $resultSubset
    ) {}

    public function getCursor(): PaginationCursor
    {
        return $this->cursor;
    }

    public function getResultSubset(): array
    {
        return $this->resultSubset;
    }

    public function current(): mixed
    {
        return $this->resultSubset[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->resultSubset[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
