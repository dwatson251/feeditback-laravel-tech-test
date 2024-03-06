<?php
declare(strict_types=1);

namespace app\Domain\Request;

class SubmitMovieRequest
{
    public string $name;
    public string $description;
    public string $imageUrl;
    public string $releaseDate;
    public string $rating;
    public bool $awardWinning;
}
