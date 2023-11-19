<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Producers\StoreRequest;
use App\Http\Requests\Api\Producers\UpdateRequest;
use App\Http\Resources\Api\ProducerResource;
use App\Models\Producer;
use App\Services\ProducerService;
use Illuminate\Support\Facades\Log;

class ProducersController extends Controller
{

    public function limitInterval() 
    {
        $result = (new ProducerService)->consultMinAndMaxInternal();
        return $result;
    }

    public function index()
    {
        $producers = Producer::orderBy('id', 'DESC')->get();
        return ProducerResource::collection($producers);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $movie = Producer::create(
            $data
        );
        return new ProducerResource($movie);
    }

    public function update(Producer $producer, UpdateRequest $request)
    {
        $data = $request->validated();
        $producer->update($data);
        return new ProducerResource($producer);
    }

    public function show(Producer $producer)
    {
        return new ProducerResource($producer); 
    }

    public function delete(Producer $producer)
    {
        $producer->delete();
        return;
    }
}
