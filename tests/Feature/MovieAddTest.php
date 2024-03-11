<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Tests\TestCase;


class MovieAddTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->testUser = new User([
            'name' => 'Test User',
            'email' => 'testuser@test.com',
            'password' => 'password'
        ]);
        $this->testUser->save();
    }

    public function testAMovieCanBeAdded()
    {
        $response = $this->put('/movies/submit', [
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
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
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
        ]))->save();

        $response = $this->put('/movies/submit', [
            'name' => $name,
            'description' => 'Starring 499 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testAMovieWithoutANameMustBeRejected()
    {
        $response = $this->put('/movies/submit', [
            'name' => '',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testAMovieWithAnInvalidRatingMustBeRejected()
    {
        $response = $this->put('/movies/submit', [
            'name' => '',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'ABC',
            'award_winning' => false,
            'user_id' => $this->testUser->id,
        ]);

        $this->assertEquals(400, $response->getStatusCode());
    }
}
