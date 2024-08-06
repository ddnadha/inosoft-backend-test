<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TransactService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactController extends Controller
{
    protected TransactService $transactService;

    public function __construct(TransactService $transactService)
    {
        $this->transactService = $transactService;
    }

    public function get(): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->transactService->report(),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->transactService->checkout($request),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }
}