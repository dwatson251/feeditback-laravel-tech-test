<?php

namespace App\Infrastructure\Repository\Movie;

use App\Domain\Entity\ApiUser;
use App\Domain\Entity\Movie\Movie;
use App\Domain\Entity\Movie\MovieSearchCriteria;
use App\Domain\Repository\Movie\MovieExistsExceptionInterface;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentMovieRepository implements MovieRepositoryInterface
{
    /**
     * @throws MovieExistsExceptionInterface
     */
    public function add(Movie $movie): void
    {
        $submitterUserId = DB::table('users')
            ->select('id')
            ->where('uuid', '=', $movie->getSubmitter()->getUuid())
            ->get('id')
        ;

        $moviesWithTheSameName = DB::table('movies')
            ->select('*')
            ->where('name', '=', $movie->getTitle())
            ->count('name')
        ;

        if ($moviesWithTheSameName >= 1) {
            throw new MovieExistsException();
        }

        DB::table('movies')->insert([
            'uuid' => $movie->getUuid(),
            'name' => $movie->getTitle(),
            'user_id' => $submitterUserId,
            'description' => $movie->getDescription() ?? '',
            'image' => $movie->getImageUrl() ?? '',
            'release_date' => $movie->getReleaseDate() ?? '',
            'rating' => $movie->getSuitabilityRating() ?? '',
            'award_winning' => $movie->isAwardWinning() ?? '',
            'created_at' => $movie->getCreatedAt(),
            'updated_at' => $movie->getUpdatedAt(),
        ]);
    }

    public function search(MovieSearchCriteria $criteria): array
    {
        $query = DB::table('movies')
            ->selectRaw('*, strftime(\'%Y\', release_date) as release_year');

        if ($criteria->getReleaseYears()) {
            $query->whereIn('release_year', $criteria->getReleaseYears());
        }

        $results = $query->get();

        return array_map(function ($result) {
            $movie = new Movie(
                $result->name,
                new \DateTimeImmutable($result->release_date),
                new ApiUser(),
            );
            return $movie;
        }, $results->toArray());
    }
}
