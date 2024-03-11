<?php
declare(strict_types=1);

namespace App\Domain\Repository\Movie;

use App\Domain\Entity\Movie\Movie;
use App\Domain\Entity\Movie\MovieSearchCriteria;

interface MovieRepositoryInterface
{
    /**
     * @throws MovieExistsExceptionInterface
     */
    public function add(Movie $movie): void;
    public function search(MovieSearchCriteria $criteria): array;
}
