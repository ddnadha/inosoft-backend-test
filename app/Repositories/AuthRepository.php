<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class AuthRepository
{
    protected User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function storeData($data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->user->create($data);
    }

    public function findByEmail($email): User|null
    {
        return $this->user->where('email', $email)->first();
    }

    public function authenticate(array $data)
    {
        if (!$token = auth()->guard('api')->attempt($data)) {
            throw new InvalidArgumentException(__('auth.password'), 401);
        }

        return $token;
    }
}
