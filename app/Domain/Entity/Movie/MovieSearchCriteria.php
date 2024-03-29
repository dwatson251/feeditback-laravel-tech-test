<?php

declare(strict_types=1);

namespace App\Domain\Entity\Movie;

use App\Models\Actor;
use App\Models\Genre;

class MovieSearchCriteria
{
    private array $releaseYears = [];
    private array $genres = [];
    private array $actors = [];
    private int $limit = 10;
    private ?string $cursor = null;

    public function __construct() {}

    public function setReleaseYears(string ...$years): MovieSearchCriteria
    {
        $this->releaseYears = $years;
        return $this;
    }

    public function setGenres(string ...$genreIds): MovieSearchCriteria
    {
        $this->genres = $genreIds;
        return $this;
    }

    public function setActors(string ...$actorIds): MovieSearchCriteria
    {
        $this->actors = $actorIds;
        return $this;
    }

    /**
     * @return array<string>
     */
    public function getReleaseYears(): array
    {
        return $this->releaseYears;
    }

    /**
     * @return array<int>
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return array<int>
     */
    public function getActors(): array
    {
        return $this->actors;
    }

    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    public function setCursor(string $cursor): MovieSearchCriteria
    {
        $this->cursor = $cursor;
        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): MovieSearchCriteria
    {
        $this->limit = $limit;
        return $this;
    }
}
