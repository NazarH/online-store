<?php

namespace App\Http\Api;

use App\Actions\Api\CreateUserAction;
use App\Actions\Api\PasswordResetAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthEmailRequest;
use App\Http\Requests\Api\AuthResetRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    private string $loginSuccess = 'Login Successful';
    private string $registerSuccess = 'Registration Successful';

    /**
     * Register a new user.
     *
     * @api {post} /auth/register Register User
     * @apiName RegisterUser
     * @apiGroup Authentication
     *
     * @apiParam {String} name User's name.
     * @apiParam {String} email User's email.
     * @apiParam {String} password User's password.
     *
     * @apiSuccess {String} success Message indicating successful registration.
     * @apiSuccess {String} token Generated API token.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();

            $user = CreateUserAction::run($data);

            return $this->tokenGenerate($user, $this->registerSuccess);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }

    /**
     * Authenticate a user and generate a token.
     *
     * @api {post} /auth/login User Login
     * @apiName LoginUser
     * @apiGroup Authentication
     *
     * @apiParam {String} email User's email.
     * @apiParam {String} password User's password.
     *
     * @apiSuccess {String} success Message indicating successful login.
     * @apiSuccess {String} token Generated API token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();

            $this->check($request);

            $user = User::where('email', '=', $data['email'])->first();

            return $this->tokenGenerate($user, $this->loginSuccess);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }

    /**
     * Перевіряє автентифікацію користувача.
     *
     * @param LoginRequest $request
     * @return JsonResponse|NULL
     */
    private function check(LoginRequest $request): JsonResponse|NULL
    {
        if (!Auth::attempt(($request->only('email', 'password')))){
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            return null;
        }
    }

    /**
     * Генерує токен для користувача та повертає відповідь з успішним повідомленням та токеном.
     *
     * @param mixed $user
     * @param string $response
     * @return JsonResponse
     */
    private function tokenGenerate($user, $response): JsonResponse
    {
        return response()->json([
            'success' => $response,
            'token' => $user->createToken('API TOKEN')
        ], 200);
    }

    /**
     * Send password reset link to user's email.
     *
     * @api {post} /auth/password/email Send Password Reset Link
     * @apiName SendPasswordResetLink
     * @apiGroup Authentication
     *
     * @apiParam {String} email User's email.
     *
     * @apiSuccess {String} success Message indicating successful link sending.
     * @apiError {String} error Message indicating failure in sending the link.
     */
    public function email(AuthEmailRequest $request): JsonResponse
    {
        try {
            $request->validated();

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json(['success' => 'Password reset link has been sent to your email']);
            } else {
                return response()->json(['error' => 'Unable to send password reset link'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }

    /**
     * Reset user's password using the provided token.
     *
     * @api {post} /auth/password/reset Password Reset
     * @apiName ResetPassword
     * @apiGroup Authentication
     *
     * @apiParam {String} token Password reset token.
     * @apiParam {String} email User's email.
     * @apiParam {String} password New password.
     *
     * @apiSuccess {String} success Message indicating successful password reset.
     * @apiError {String} error Message indicating failure in password reset.
     */
    public function reset(AuthResetRequest $request): JsonResponse
    {
        try {
            $request->validated();

            $status = PasswordResetAction::run($request);

            if ($status == Password::PASSWORD_RESET) {
                return response()->json(['success' => 'Password has been reset successfully']);
            } else if ($status == Password::INVALID_TOKEN) {
                return response()->json(['error' => 'Invalid token'], 400);
            } else if ($status == Password::INVALID_USER) {
                return response()->json(['error' => 'Invalid email address'], 400);
            } else {
                return response()->json(['error' => 'Unable to reset password'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bad Request'], 400);
        }
    }
}
