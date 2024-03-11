<?php
declare(strict_types=1);

namespace App\Domain\Repository\Movie;

use app\Domain\DTO\Movie\MovieSearchCriteria;
use App\Domain\Entity\Movie\Movie;

interface MovieRepositoryInterface
{
    public function add(Movie $movie): void;
    public function search(MovieSearchCriteria $criteria): array;
}
