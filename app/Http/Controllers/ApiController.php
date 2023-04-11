<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    protected function successResponse(mixed $result = null, int $status = 200, string $message = 'success'): JsonResponse
    {
        return response()->json([
            'result' => $result,
            'message' => $message
        ], $status);
    }

    protected function errorResponse(mixed $result = null, int $status = 400, string $message = 'error'): JsonResponse
    {
        return response()->json([
            'result' => $result,
            'message' => $message
        ], $status);
    }
}
