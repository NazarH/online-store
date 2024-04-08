<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Notification\NotificationCreateAction;
use App\Actions\Admin\Notification\NotificationSendAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::paginate(10);

        return view('admin.notifications.index', ['notifications' => $notifications]);
    }

    public function create(): View
    {
        return view('admin.notifications.create');
    }

    public function send(StoreRequest $request, NotificationSendAction $action): RedirectResponse
    {
        $data = $request->validated();

        if ($data['notification_date'] > now()) {
            Notification::create($data);
            return redirect()->route('admin.leads.notifications.index');
        }

        $action->handle($data);

        return redirect()->route('admin.leads.notifications.index');
    }

    public function edit(Notification $notification): View
    {
        return view('admin.notifications.edit', ['notification' => $notification]);
    }

    public function update(StoreRequest $request, Notification $notification): RedirectResponse
    {
        $data = $request->validated();

        $notification->update($data);

        return redirect()->route('admin.leads.notifications.index');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('admin.leads.notifications.index');
    }
}
