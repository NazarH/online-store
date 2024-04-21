<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Subscribe a user to the newsletter.
     *
     * @api {post} /subscribe Subscribe User
     * @apiName SubscribeUser
     * @apiGroup Subscribe
     *
     * @apiParam {String} email User's email address.
     *
     */
    public function subscribe(Request $request): JsonResponse
    {
        try {
            $user = User::where('email', '=', $request->email)->first();

            Lead::create([
                'user_id' => $user->id,
                'type' => 'subscription'
            ]);

            return response()->json(['success' => 'Subscribed Successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
