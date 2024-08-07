<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vehicle;
use App\Repositories\VehicleRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class VehicleService
{
    protected VehicleRepository $vehicleRepository;
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function index(): array
    {
        return $this->vehicleRepository->getAll();
    }

    public function store(array $data): Vehicle
    {
        $validator = Validator::make($data, [
            'manufactured_at' => 'required|integer',
            'color' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:motorcycle,car',
            'detailedInfo' => 'required|array',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 400);
        }

        return $this->vehicleRepository->save($data);
    }

    public function show($id): ?Vehicle
    {
        $vehicle = $this->vehicleRepository->getById($id);

        if (!$vehicle) {
            throw new NotFoundResourceException("not found", 404);
        }

        return $vehicle;
    }

    public function update($id, array $data): Vehicle
    {
        $validator = Validator::make($data, [
            'manufactured_at' => 'integer',
            'color' => 'string',
            'price' => 'numeric',
            'type' => 'in:motorcycle,car',
            'detailedInfo' => 'array',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 400);
        }

        $vehicle = $this->vehicleRepository->getById($id);

        if (!$vehicle) {
            throw new NotFoundResourceException("not found", 404);
        }

        return $this->vehicleRepository->update($id, $data);
    }

    public function delete($id): mixed
    {
        $vehicle = $this->vehicleRepository->getById($id);

        if (!$vehicle) {
            throw new NotFoundResourceException("not found", 404);
        }

        return $this->vehicleRepository->delete($id);
    }
}
