<?php
declare(strict_types=1);

namespace App\Domain\Request;

use Illuminate\Http\Request;

class AddMovieRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }

    public string $user;

    public string $name;
    public string $description;
    public string $imageUrl;
    public string $releaseDate;
    public string $rating;
    public bool $awardWinning;
}
