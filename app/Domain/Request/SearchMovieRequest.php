<?php
declare(strict_types=1);

namespace App\Domain\Request;

class SearchMovieRequest
{
    public int $yearMin;
    public int $yearMax;

    /**
     * @var array<int>
     */
    public array $actorIds;

    /**
     * @var array<int>
     */
    public array $genreIds;
}
