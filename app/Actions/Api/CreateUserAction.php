<?php

namespace App\Actions\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUserAction
{
    use AsAction;

    /**
     * Створює нового користувача на основі отриманих даних.
     *
     * @param array $data Дані нового користувача.
     */
    public function handle(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return $user;
    }
}
