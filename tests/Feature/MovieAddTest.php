<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Controllers\Movie\Add
 */
class MovieAddTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->testUser = new User([
            'name' => 'Test User',
            'email' => 'testuser@test.com',
            'password' => 'password',
            'uuid' => Str::uuid()->toString(),
        ]);
        $this->testUser->save();
    }

    public function testAMovieCanBeAdded()
    {
        $response = $this->put('/api/movies/new', [
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-12-31 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user' => $this->testUser->uuid,
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testAMovieWithTheSameNameCannotBeAdded()
    {
        $name = 'A fun movie about cats';

        (new Movie([
            'name' => $name,
            'description' => 'Starring 499 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-12-31 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
            'uuid' => Str::uuid()->toString(),
        ]))->save();

        $response = $this->put('/api/movies/new', [
            'name' => $name,
            'description' => 'Starring 499 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-12-31 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user' => $this->testUser->uuid,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testAMovieWithoutANameMustBeRejected()
    {
        $response = $this->put('/api/movies/new', [
            'name' => '',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-12-31 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user' => $this->testUser->uuid,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testAMovieWithAnInvalidRatingMustBeRejected()
    {
        $response = $this->put('/api/movies/new', [
            'name' => 'A Movie',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-12-31 23:59:59',
            'rating' => 'ABC',
            'award_winning' => false,
            'user' => $this->testUser->uuid,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }
}
