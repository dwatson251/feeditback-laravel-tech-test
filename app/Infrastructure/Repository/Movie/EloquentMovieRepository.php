<?php

namespace App\Infrastructure\Repository\Movie;

use App\Domain\Entity\ApiUser;
use App\Domain\Entity\EntityResultCollection;
use App\Domain\Entity\Movie\Movie;
use App\Domain\Entity\Movie\MovieSearchCriteria;
use App\Domain\Entity\Movie\SuitabilityRating;
use App\Domain\Entity\PaginationCursor;
use App\Domain\Repository\Movie\MovieExistsExceptionInterface;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use Doctrine\DBAL\Query;
use Illuminate\Support\Facades\DB;

class EloquentMovieRepository implements MovieRepositoryInterface
{
    /**
     * @throws MovieExistsExceptionInterface
     */
    public function add(Movie $movie): void
    {
        DB::beginTransaction();

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
            DB::rollBack();
            throw new MovieExistsException();
        }

        DB::table('movies')->insert([
            'uuid' => $movie->getUuid(),
            'name' => $movie->getTitle(),
            'user_id' => $submitterUserId,
            'description' => $movie->getSynopsis() ?? '',
            'image' => $movie->getImageUrl() ?? '',
            'release_date' => $movie->getReleaseDate() ?? '',
            'rating' => $movie->getSuitabilityRating() ?? '',
            'award_winning' => $movie->isAwardWinning() ?? '',
            'created_at' => $movie->getCreatedAt(),
            'updated_at' => $movie->getUpdatedAt(),
        ]);

        DB::commit();
    }

    public function search(MovieSearchCriteria $criteria): EntityResultCollection
    {
        $query = DB::table('movies');
        $query->join('users', 'users.id', '=', 'movies.user_id');
        $query->select([
            'users.uuid AS user_uuid',
            'movies.*'
        ]);

        if ($criteria->getReleaseYears()) {
            $query->where(function($query) use ($criteria) {
                foreach ($criteria->getReleaseYears() as $releaseYear) {
                    /**
                     * The preference would be to use an IN clause here, but we have limitations with its support
                     * in eloquent. Using YEAR, strftime, or DATE_FORMAT functions are not interoperable between
                     * mysql and sqlite.
                     */
                    $query->orWhereYear('movies.release_date', '=', $releaseYear);
                }
            });
        }

        if ($criteria->getActors() || $criteria->getGenres()) {
            $query->where(function ($query) use ($criteria) {
                if ($criteria->getActors()) {
                    $query->orWhereIn('actors', $criteria->getActors());
                }
                if ($criteria->getGenres()) {
                    $query->orWhereIn('genres', $criteria->getGenres());
                }
            });
        }

        $query->orderBy('movies.created_at');
        $results = $query->cursorPaginate($criteria->getLimit(), ['*'], 'cursor', $criteria->getCursor());

        return new EntityResultCollection(
            new PaginationCursor(
                $results->cursor()?->encode(),
                $results->nextCursor()?->encode(),
                $results->previousCursor()?->encode(),
            ),
            array_map(function (\stdClass $movieResult) {
                $movie = new Movie(
                    $movieResult->name,
                    new \DateTimeImmutable($movieResult->release_date),
                    new ApiUser($movieResult->user_uuid)
                );
                $movie->setUuid($movieResult->uuid);
                $movie->setSynopsis($movieResult->description);
                $movie->setImageUrl($movieResult->image);
                $movie->setSuitabilityRating(SuitabilityRating::tryFrom($movieResult->rating));
                $movie->setAwardWinning($movieResult->award_winning);
                return $movie;
            }, $results->items()),
        );
    }
}
