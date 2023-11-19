<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Movies\StoreRequest;
use App\Http\Requests\Api\Movies\UpdateRequest;
use App\Http\Resources\Api\MovieResource;
use App\Models\Movie;
use GuzzleHttp\Psr7\Request;

class MoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'DESC')->get();
        return MovieResource::collection($movies);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $movie = Movie::create(
            $data
        );
        return new MovieResource($movie);
    }

    public function update(Movie $movie, UpdateRequest $request)
    {
        $data = $request->validated();
        $movie->update($data);
        return new MovieResource($movie);
    }

    public function show(Movie $movie)
    {
        return new MovieResource($movie); 
    }

    public function delete(Movie $movie)
    {
        $movie->delete();
        return;
    }
}
