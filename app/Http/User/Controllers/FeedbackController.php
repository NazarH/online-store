<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\User\Requests\FeedbackRequest;
use App\Models\Lead;
use App\Models\User;

class FeedbackController extends Controller
{
    public function index()
    {
        $subscribes = Lead::where('user_id', '=', auth()->id())->get();

        return view('client.feedback.index', ['subscribes' => $subscribes]);
    }

    public function store(FeedbackRequest $request, User $user)
    {
        $data = $request->validated();

        Lead::firstOrCreate([
            'type' => $data['type'],
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }
}
