<?php

namespace App\Actions\Admin\User;

use App\Models\User;

class UserStoreAction
{
    public function handle($data)
    {
        $data['role'] = 'client';

        User::create($data);
    }
}
