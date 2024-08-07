<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AuthService
{
    protected AuthRepository $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function store(array $data): User
    {
        $validator = Validator::make($data, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }

        return $this->authRepository->storeData($data);
    }

    public function login(array $data)
    {
        $validator = Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }

        $user = $this->authRepository->findByEmail($data['email']);
        if (!$user) {
            throw new Exception(__('auth.failed'), 401);
        }

        return [
            'status' => 200,
            'data' => $user,
            'token' => $this->authRepository->authenticate($data)
        ];
    }
}
