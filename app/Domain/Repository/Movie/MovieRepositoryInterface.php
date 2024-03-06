<?php
declare(strict_types=1);

namespace app\Domain\Repository\Movie;

use app\Domain\DTO\Movie\MovieSearchCriteria;
use App\Models\Movie;

interface MovieRepositoryInterface
{
    public function addNew(Movie $movie): void;
    public function search(MovieSearchCriteria $criteria): array;
}
