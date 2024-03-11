<?php

namespace App\Infrastructure\Repository\Movie;

use App\Domain\Repository\Movie\MovieExistsExceptionInterface;

class MovieExistsException extends \Exception implements MovieExistsExceptionInterface {}
