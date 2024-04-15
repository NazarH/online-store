<?php

namespace App\Actions\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class PasswordResetAction
{
    use AsAction;

    /**
     * Обробляє запит на скидання паролю користувача.
     *
     * @param Request $request
     * @return Password
     */
    public function handle(Request $request): Password
    {
        return Password::reset(
            $request->only('email', 'password', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
    }
}
