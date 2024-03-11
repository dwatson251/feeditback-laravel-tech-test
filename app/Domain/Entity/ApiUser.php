<?php

namespace App\Domain\Entity;

use Illuminate\Support\Str;

class ApiUser
{
    private string $uuid;

    public function __construct() {
        $this->uuid = Str::uuid()->toString();
    }

    public function setUuid(string $uuid): ApiUser
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
