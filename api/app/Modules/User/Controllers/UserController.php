<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Address\Requests\AddressRequest;
use App\Modules\User\Requests\UserRequest;
use App\Modules\User\Services\AuthService;
use App\Modules\User\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $authService;
    protected $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $response = $this->authService->login($request->all());

        return response()->json($response['data'] ?? ['message' => $response['message']], $response['status']);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function store(UserRequest $request, AddressRequest $addressRequest)
    {
        $user = $this->userService->register($request->all(), $addressRequest->all());

        return response()->json([
            'message' => 'Usuário registrado com sucesso',
            'user' => $user,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $response = $this->userService->update($id, $request->all());

        if (isset($response['status'])) {
            return response()->json(['message' => $response['message']], $response['status']);
        }

        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            'user' => $response,
        ]);
    }
}
