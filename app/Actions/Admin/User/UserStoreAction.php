<?php

namespace App\Actions\Admin\User;

use App\Models\User;

class UserStoreAction
{
    /**
     * Обробляє створення користувача.
     *
     * @param array $data Дані для створення користувача.
     * @return void
     */
    public function handle(array $data): void
    {
        $data['role'] = 'client';

        User::create($data);
    }
}
