<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Notification\NotificationSendAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Показує список повідомлень.
     *
     * @return View
     */
    public function index(): View
    {
        $notifications = Notification::paginate(10);

        return view('admin.notifications.index', ['notifications' => $notifications]);
    }

    /**
     * Показує форму для створення нового повідомлення.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.notifications.create');
    }

    /**
     * Відправляє нове повідомлення або створює його для відправлення в майбутньому.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function send(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($data['notification_date'] > now()) {
            Notification::create($data);
            return redirect()->route('admin.leads.notifications.index');
        }

        NotificationSendAction::run($data);

        return redirect()->route('admin.leads.notifications.index');
    }

    /**
     * Показує форму для редагування конкретного повідомлення.
     *
     * @param Notification $notification
     * @return View
     */
    public function edit(Notification $notification): View
    {
        return view('admin.notifications.edit', ['notification' => $notification]);
    }

    /**
     * Оновлює існуюче повідомлення в базі даних.
     *
     * @param StoreRequest $request
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Notification $notification): RedirectResponse
    {
        $data = $request->validated();

        $notification->update($data);

        return redirect()->route('admin.leads.notifications.index');
    }

    /**
     * Видаляє конкретне повідомлення з бази даних.
     *
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('admin.leads.notifications.index');
    }
}
