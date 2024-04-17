<?php

namespace App\Actions\Admin\User;

use App\Models\Photo;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UserStoreAction
{
    use AsAction;

    /**
     * Обробляє створення користувача.
     *
     * @param array $data Дані для створення користувача.
     * @param $file
     * @return void
     */
    public function handle(array $data, $file): void
    {
        $data['role'] = 'client';

       $user = User::create($data);

        if ($file) {
            $path = $file->store('avatars', 'public');

            Photo::create([
                'name' => basename($path),
                'model_type' => 'users',
                'model_id' => $user->id
            ]);
        }
    }
}
