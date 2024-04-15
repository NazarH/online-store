<?php

namespace App\Actions\Api;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePhotoAction
{
    use AsAction;

    /**
     * Обробляє завантаження аватарки користувача.
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function handle(Request $request, User $user): void
    {
        $file = $request->file('avatar');
        $path = $file->store('avatars', 'public');

        Photo::create([
            'name' => basename($path),
            'model_type' => 'users',
            'model_id' => $user->id
        ]);
    }
}
