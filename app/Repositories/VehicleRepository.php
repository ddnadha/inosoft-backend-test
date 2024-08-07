<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    protected Vehicle $vehicle;
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }

    public function getAll(): array
    {
        return $this->vehicle->get()->toArray();
    }

    public function getById($id): ?Vehicle
    {
        return $this->vehicle->find($id);
    }

    public function save(array $data): Vehicle
    {
        return $this->vehicle->create($data);
    }

    public function update($id, array $data): Vehicle
    {
        return $this->vehicle->where('_id', $id)->update($data);
    }

    public function delete($id): mixed
    {
        return $this->vehicle->where('_id', $id)->delete();
    }
}
