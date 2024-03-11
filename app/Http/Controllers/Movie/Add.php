<?php
declare(strict_types=1);

namespace App\Http\Controllers\Movie;

use App\Domain\Entity\ApiUser;
use App\Domain\Entity\Movie\Movie;
use App\Domain\Entity\Movie\SuitabilityRating;
use App\Domain\Repository\Movie\MovieExistsExceptionInterface;
use App\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Domain\Request\AddMovieRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class Add extends Controller
{
    public function __construct(
        private MovieRepositoryInterface $movieRepository,
    ) {}

    public function __invoke(Request $request): Response
    {
        $input = $request->all();
        $apiUser = (new ApiUser($input['user']));

        if (empty($input['name'])) {
            return new Response('Movie name cannot be empty', 400);
        }

        if (!empty($input['rating']) && SuitabilityRating::tryFrom($input['rating']) === null) {
            return new Response('A valid movie rating must be used', 400);
        }

        $movieToAdd = new Movie(
            $input['name'],
            new \DateTimeImmutable($input['release_date']),
            $apiUser,
        );

        try {
            $this->movieRepository->add($movieToAdd);
        } catch (MovieExistsExceptionInterface $e) {
            return new Response('Movie with this name already exists', 400);
        }

        return new Response(null, 201);
    }
}
