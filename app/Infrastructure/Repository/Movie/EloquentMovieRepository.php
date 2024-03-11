<?php

namespace App\Infrastructure\Repository\Movie;

use app\Domain\DTO\Movie\MovieSearchCriteria;
use App\Domain\Entity\Movie\Movie;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentMovieRepository implements MovieRepositoryInterface
{
    public function add(Movie $movie): void
    {
        $submitter = DB::table('users')
            ->selectRaw('id')
            ->where('uuid', '=', $movie->getSubmitter()->getUuid())
        ;

        DB::table('movies')->insert([
            'uuid' => $movie->getUuid(),
            'name' => $movie->getTitle(),
            'user_id' => $submitter['id'],
            'image' => $movie->getImageUrl(),
            'release_date' => $movie->getReleaseDate(),
            'rating' => $movie->getSuitabilityRating(),
            'award_winning' => $movie->isAwardWinning(),
            'created_at' => $movie->getCreatedAt(),
            'updated_at' => $movie->getUpdatedAt(),
        ]);
    }

    public function search(MovieSearchCriteria $criteria): array
    {
        return [];
    }
}
