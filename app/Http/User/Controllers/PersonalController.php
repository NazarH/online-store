<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\User\Requests\ClientUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonalController extends Controller
{
    /**
     * Відображає особистий кабінет користувача.
     *
     * @return View
     */
    public function index(): View
    {
        return view('client.personal.index');
    }

    /**
     * Оновлює дані користувача.
     *
     * @param ClientUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(ClientUpdateRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $user->update($data);

        return redirect()->route('client.personal.index');
    }
}
