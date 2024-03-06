<?php

namespace App\Http\Controllers;

class MovieController extends Controller
{
    public function index()
    {
        /**
         * A user can filter movies by the following:
         * Release date
         * Genres
         * Actors
         *
         * Write code which will return movies based on these filters.
         * Filters will be passed as query parameters.
         * A user can pass multiple genres/actors
         * All filters are optional
         * If genres and actors are present results must match one OR the other.
         *
         * You should seed 5000 movies (with related data) using the factory for this endpoint to use.
         *
         * When returning the user data we want to emit the user_id of the user which created the movie.
         * Use a JsonResource to return results
         */

    }

    public function store()
    {
        /**
         * A user can create a movie and link it to genres/actors
         *
         * Write code which will allow a user to create the movie with the associated data
         * Be sure to have appropriate validation.
         */
    }
}
