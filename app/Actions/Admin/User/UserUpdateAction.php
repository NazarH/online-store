<?php

namespace App\Actions\Admin\User;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;

class UserUpdateAction
{
    use AsAction;

    /**
     * Обробляє оновлення інформації про користувача.
     *
     * @param UploadedFile|null $file Файл зображення користувача.
     * @param array $data Дані для оновлення користувача.
     * @param User $user Користувач, якого потрібно оновити.
     * @return void
     */
    public function handle(UploadedFile|null $file, array $data, User $user): void
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
