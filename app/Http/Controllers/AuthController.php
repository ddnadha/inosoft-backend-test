<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->only('email', 'password'));
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->authService->store($request->all()),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}
