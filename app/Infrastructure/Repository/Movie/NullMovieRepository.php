<?php

namespace App\Infrastructure\Repository\Movie;

use App\Domain\Entity\EntityResultCollection;
use App\Domain\Entity\Movie\MovieSearchCriteria;
use App\Domain\Entity\PaginationCursor;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Models\Movie;

class NullMovieRepository implements MovieRepositoryInterface
{

    public function add(Movie $movie): void
    {
        // Nothing to do.
    }

    public function search(MovieSearchCriteria $criteria): EntityResultCollection
    {
        return new EntityResultCollection(new PaginationCursor(), []);
    }
}
