<?php

declare(strict_types=1);

namespace App\Domain\Entity\Movie;
use App\Domain\Entity\ApiUser;
use App\Domain\Entity\EntityInterface;
use Illuminate\Support\Str;

class Movie implements EntityInterface
{
    private string $uuid;
    private ?string $synopsis = null;
    private ?string $imageUrl = null;
    private ?SuitabilityRating $suitabilityRating = null;
    private ?bool $awardWinning = null;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;

    public function __construct(
        private string $title,
        private \DateTimeInterface $releaseDate,
        private ApiUser $submitter,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->uuid = Str::uuid()->toString();
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new \DateTimeImmutable();
    }

    public function setUuid(string $uuid): Movie
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function setSynopsis(string $synopsis): Movie
    {
        $this->synopsis = $synopsis;
        return $this;
    }

    public function setImageUrl(string $imageUrl): Movie
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setSuitabilityRating(?SuitabilityRating $suitabilityRating): Movie
    {
        $this->suitabilityRating = $suitabilityRating;
        return $this;
    }

    public function setAwardWinning(bool $isAwardWinning): Movie
    {
        $this->awardWinning = $isAwardWinning;
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getSuitabilityRating(): ?SuitabilityRating
    {
        return $this->suitabilityRating;
    }

    public function isAwardWinning(): ?bool
    {
        return $this->awardWinning;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReleaseDate(): \DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function getSubmitter(): ApiUser
    {
        return $this->submitter;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'image_url' => $this->imageUrl,
            'release_date' => $this->releaseDate->format('Y-m-d'),
            'suitability_rating' => $this->suitabilityRating,
            'is_award_winning' => $this->awardWinning,
            'created_at' => $this->createdAt->format(\DATE_ATOM),
            'updated_at' => $this->updatedAt->format(\DATE_ATOM),
            'submitter_user' => $this->submitter->getUuid(),
        ];
    }
}
