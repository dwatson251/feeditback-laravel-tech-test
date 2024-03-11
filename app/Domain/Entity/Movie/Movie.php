<?php

declare(strict_types=1);

namespace App\Domain\Entity\Movie;
use App\Domain\Entity\ApiUser;
use Illuminate\Support\Str;

class Movie
{
    private string $uuid;
    private string $description;
    private string $imageUrl;
    private SuitabilityRating $suitabilityRating;
    private bool $awardWinning;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $updatedAt;

    public function __construct(
        private string $title,
        private \DateTimeInterface $releaseDate,
        private ApiUser $submitter,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
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

    public function setDescription(string $description): Movie
    {
        $this->description = $description;
        return $this;
    }

    public function setImageUrl(string $imageUrl): Movie
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setSuitabilityRating(SuitabilityRating $suitabilityRating): Movie
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getSuitabilityRating(): SuitabilityRating
    {
        return $this->suitabilityRating;
    }

    public function isAwardWinning(): bool
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
}
