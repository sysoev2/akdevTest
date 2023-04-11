<?php

namespace App\Http\Controllers;

use App\Factories\UserDTOFactory;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = UserDTOFactory::fromRequest($request);
        $token = $this->userService->register($dto);
        return $this->successResponse(['token' => $token], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $dto = UserDTOFactory::fromRequest($request);
        $token = $this->userService->login($dto);
        if($token) {
            return $this->successResponse(['token' => $token]);
        }
        return $this->errorResponse(null, 401, 'Invalid username or password');
    }
}
