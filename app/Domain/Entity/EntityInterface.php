<?php
declare(strict_types=1);

namespace App\Domain\Entity;

interface EntityInterface
{
    public function toArray(): array;
}
