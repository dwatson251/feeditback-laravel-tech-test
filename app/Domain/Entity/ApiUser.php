<?php

namespace App\Domain\Entity;

use Illuminate\Support\Str;

class ApiUser
{
    private string $uuid;

    public function __construct(?string $uuid = null) {
        $this->uuid = $uuid ?? Str::uuid()->toString();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
