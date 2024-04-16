<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\FilterAction;
use App\Actions\Admin\User\UserStoreAction;
use App\Actions\Admin\User\UserUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Показує список користувачів з можливістю фільтрації та сортування.
     *
     * @param FilterAction $filter
     * @param string $sortBy
     * @return View
     */
    public function index(FilterAction $filter, string $sortBy = 'id'): View
    {
        $query = User::query();

        if (Request::all()) {
            $query = $filter->handle($query);
        }

        $this->sortUsers($sortBy);

        $users = $query->orderBy($sortBy, Session::get('users'))->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Сортує користувачів в залежності від обраного поля та порядку сортування.
     *
     * @param string $sortBy
     * @return void
     */
    private function sortUsers(string $sortBy): void
    {
        if ($sortBy !== 'id') {
            if (empty(Session::get('users')) || Session::get('users') === 'desc') {
                Session::put('users', 'asc');
            } else if(Session::get('users') === 'asc') {
                Session::put('users', 'desc');
            }
        } else {
            Session::put('users', 'asc');
        }
    }

    /**
     * Показує форму для створення нового користувача.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Зберігає нового користувача в базі даних.
     *
     * @param StoreRequest $request
     * @param UserStoreAction $action
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, UserStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        Cache::forget('statistic');

        return redirect()->route('admin.users.index');
    }

    /**
     * Показує форму для редагування конкретного користувача.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $avatar = $user->avatar($user->id)?->name;

        return view('admin.users.edit', ['user' => $user, 'avatar' => $avatar]);
    }

    /**
     * Оновлює існуючого користувача в базі даних.
     *
     * @param StoreRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, User $user): RedirectResponse
    {
        $file = $request->file('image');
        $data = $request->validated();

        UserUpdateAction::run($file, $data, $user);

        return redirect()->route('admin.users.index');
    }

    /**
     * Видаляє конкретного користувача з бази даних.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        Cache::forget('statistic');

        return redirect()->route('admin.users.index');
    }
}
