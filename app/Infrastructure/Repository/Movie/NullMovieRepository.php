<?php

namespace App\Infrastructure\Repository\Movie;

use app\Domain\DTO\Movie\MovieSearchCriteria;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Models\Movie;

class NullMovieRepository implements MovieRepositoryInterface
{

    public function add(Movie $movie): void
    {
        return;
    }

    public function search(MovieSearchCriteria $criteria): array
    {
        return [];
    }
}
