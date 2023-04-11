<?php

namespace App\Services;


use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(UserDTO $dto): string
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password)
        ]);

        return $user->createApiToken();
    }

    public function login(UserDTO $dto): ?string
    {
        $credentials = [
            'email' => $dto->email,
            'password' => $dto->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('api_token')->plainTextToken;
        } else {
            $token = null;
        }

        return $token;
    }

    public function update(){}


}
