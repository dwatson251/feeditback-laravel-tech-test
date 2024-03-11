<?php
declare(strict_types=1);

namespace App\Domain\Request;

use Illuminate\Http\Request;

class SearchMovieRequest extends Request
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
