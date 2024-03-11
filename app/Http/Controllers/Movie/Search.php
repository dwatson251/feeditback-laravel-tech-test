<?php

declare(strict_types=1);

namespace App\Http\Controllers\Movie;

use App\Domain\Entity\Movie\MovieSearchCriteria;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Search extends Controller
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository,
    ) {}

    public function __invoke(Request $request): Response
    {
        $input = $request->all();

        $criteria = new MovieSearchCriteria();

        if (!empty($input['releaseYears'])) {
            $criteria->setReleaseYears(...$input['releaseYears']);
        }

        $results = $this->movieRepository->search($criteria);

        return new JsonResponse($results, 200);
    }
}
