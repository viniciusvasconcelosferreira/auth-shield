<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $credentials)
    {
        $validated = validator($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return [
                'message' => 'Credenciais inválidas',
                'status' => 401,
            ];
        }

        $existingToken = $user->tokens()->where('name', 'auth_token')->first();

        if ($existingToken) {
            $existingToken->delete();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'data' => [
                'message' => 'Login realizado com sucesso',
                'token' => $token,
                'user' => $user,
            ],
            'status' => 200,
        ];
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
    }
}