<?php
declare(strict_types=1);

namespace App\Http\Controllers\Movie;

use app\Domain\Repository\Movie\MovieRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Add extends Controller
{
    public function __construct(MovieRepositoryInterface $movieRepository)
    {
    }

    public function __invoke(Request $request): Response
    {
        return new Response(null, 201);
    }
}
