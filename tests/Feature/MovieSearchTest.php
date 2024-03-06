<?php
declare(strict_types=1);

namespace tests\Feature;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Tests\CreatesApplication;
use Tests\TestCase;

class MovieSearchTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    private User $testUser;

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

    public function testAMovieCanBeSearched()
    {
        (new Movie([
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser,
        ]))->save();

        $criteriaString = [
            'releaseYears' => [2010],
        ];

        $response = $this->get('movies/search?' . http_build_query($criteriaString));
        $resultsParsed = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(1, $resultsParsed);
    }

    public function testAMovieOutsideSearchCriteriaIsNotReturned()
    {
        (new Movie([
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'user_id' => $this->testUser,
        ]))->save();

        $criteriaString = [
            'releaseYears' => [2021],
        ];

        $response = $this->get('movies/search?' . http_build_query($criteriaString));
        $resultsParsed = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(0, $resultsParsed);
    }

    public function testSearchWithGenreAndActorReturnsResultsThatContainEither()
    {
        $actor = new Actor([
            'name' => 'Aaron A Aaronson',
        ]);
        $actor->save();

        $genre = new Genre([
            'name' => 'cats',
        ]);
        $genre->save();

        (new Movie([
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'actors' => [$actor],
            'genres' => [],
            'user_id' => $this->testUser,
        ]))->save();

        (new Movie([
            'name' => 'A fun movie about cats',
            'description' => 'Starring 500 cats, this is a fantastic movie about cats',
            'image' => '',
            'release_date' => '2010-31-12 23:59:59',
            'rating' => 'U',
            'award_winning' => false,
            'actors' => [],
            'genres' => [$genre],
            'user_id' => $this->testUser,
        ]))->save();

        $criteriaString = [
            'actors' => [$actor->id],
            'genres' => [$genre->id],
        ];

        $response = $this->get('movies/search?' . http_build_query($criteriaString));
        $resultsParsed = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(2, $resultsParsed);
    }
}