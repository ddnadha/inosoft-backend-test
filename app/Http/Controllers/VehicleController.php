<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use MongoDB\Client;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicle = Vehicle::all();
        return response()->json($vehicle);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manufactured_at' => 'required|integer',
            'color' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:motorcycle,car',
            'detailedInfo' => 'required|array',
        ]);

        // $vehicle = Vehicle::create($validated);
        $client = new Client(env("MONGODB_URI"));
        $vehicle = $client->inorctest->vehicles->insertOne($validated);
        $insertedId = $vehicle->getInsertedId();
        $insertedDocument = $client->inorctest->vehicles->findOne(['_id' => $insertedId]);

        return response()->json($insertedDocument, 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validated = $request->validate([
            'manufactured_at' => 'integer',
            'color' => 'string',
            'price' => 'numeric',
            'type' => 'in:Motor,Mobil',
            'detailedInfo' => 'array',
        ]);

        $vehicle->update($validated);
        return response()->json($vehicle);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return response()->json(null, 204);
    }
}
