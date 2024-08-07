<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transact;
use App\Models\Vehicle;
use App\Repositories\TransactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class TransactService
{
    protected TransactRepository $transactionRepository;

    public function __construct(TransactRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function checkout(array $data): Transact
    {
        $validator = Validator::make($data, [
            'price' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'string'],
            'items.*.price' => ['required', 'numeric'],
            'items.*.qty' => ['required', 'int'],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }

        return $this->transactionRepository->storeData($data);
    }

    public function report(): array
    {
        return $this->transactionRepository->getAll();
    }
}
