<?php

namespace App\Actions\Admin\User;

use App\Models\Photo;

class UserUpdateAction
{
    public function handle($file, $data, $user)
    {
        $data = array_diff($data, array(null));
        $user->update($data);

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
