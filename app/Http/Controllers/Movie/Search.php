<?php

declare(strict_types=1);

namespace App\Http\Controllers\Movie;

use App\Domain\Entity\Movie\Movie;
use App\Domain\Entity\Movie\MovieSearchCriteria;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Search extends Controller
{
    public function __construct(
        private readonly MovieRepositoryInterface $movieRepository,
    ) {}

    public function __invoke(Request $request): Response
    {
        $input = $request->all();

        $criteria = new MovieSearchCriteria();

        if (!empty($input['cursor'])) {
            $criteria->setCursor($input['cursor']);
        }

        if (!empty($input['years'])) {
            $criteria->setReleaseYears(...$input['years']);
        }

        if (!empty($input['genres'])) {
            $criteria->setGenres(...$input['genres']);
        }

        if (!empty($input['actors'])) {
            $criteria->setActors(...$input['actors']);
        }

        $collection = $this->movieRepository->search($criteria);

        /**
         * Non-functional requirements state to return a JsonResource. I have decided to return a
         * JsonResponse due to PSR-7 compliance and control over using domain objects rather
         * than coupling Laravel ones.
         *
         * Functionally the following will return similar structures.
         */
        return new JsonResponse([
            'data' => array_map(function(Movie $movie) {
                return $movie->toArray();
            }, $collection->getResultSubset()),
            'meta' => [
                'current' => $collection->getCursor()->getCurrent(),
                'next' => $collection->getCursor()->getNext(),
                'previous' => $collection->getCursor()->getPrevious(),
            ],
        ]);
    }
}
