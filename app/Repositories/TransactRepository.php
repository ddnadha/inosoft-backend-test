<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transact;
use App\Models\Vehicle;

class TransactRepository
{
    protected Transact $transact;
    protected Vehicle $vehicle;
    public function __construct(Transact $transact, Vehicle $vehicle)
    {
        $this->transact = $transact;
        $this->vehicle = $vehicle;
    }

    public function storeData(array $data): Transact
    {
        foreach ($data['items'] as $item) {
            $this->vehicle
                ->where('_id', $item['id'])
                ->decrement('stock', $item['qty']);
        }
        $transact = $this->transact->create($data);
        return $transact;
    }

    public function getAll(): array
    {
        return $this->transact->all()->toArray();
    }
}
