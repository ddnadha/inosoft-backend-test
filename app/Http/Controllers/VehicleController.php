<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\VehicleService;
use Exception;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected VehicleService $vehicleService;
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function index()
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->vehicleService->index(),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function store(Request $request)
    {
        try {
            $result = [
                'status' => 201,
                'data' => $this->vehicleService->store($request->all()),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function show($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->vehicleService->show($id),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function update(Request $request, $id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->vehicleService->update($id, $request->all()),
            ];
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode() == 0 ? 500 : $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function destroy($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->vehicleService->delete($id),
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
