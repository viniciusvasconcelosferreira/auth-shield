<?php

namespace App\Modules\User\Services;

use App\Modules\Address\Models\Address;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function register(array $userData, array $addressData)
    {
        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        $this->createAddress($user->id, $addressData);

        return $user;
    }

    protected function createAddress($userId, array $addressData)
    {
        $addressData['user_id'] = $userId;

        Address::create($addressData);
    }

    public function update($id, array $data)
    {
        try {
            $user = User::findOrFail($id);

            $validated = validator($data, [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8',
            ])->validate();

            if (isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $user->update($validated);

            return $user;
        } catch (ModelNotFoundException $e) {
            return [
                'message' => 'Usuário não encontrado',
                'status' => 404,
            ];
        }
    }
}