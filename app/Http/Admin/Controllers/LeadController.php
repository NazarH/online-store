<?php

namespace App\Http\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreRequest;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Показує список потенційних клієнтів (лідів).
     *
     * @return View
     */
    public function index(): View
    {
        $leads = Lead::query()->with('user')->paginate(10);

        return view('admin.leads.index', ['leads' => $leads]);
    }

    /**
     * Показує форму для створення нового ліда.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.leads.create');
    }

    /**
     * Зберігає нового ліда в базі даних.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Lead::create($data);

        Cache::forget('statistic');

        return redirect()->route('admin.leads.index');
    }

    /**
     * Показує форму для редагування конкретного ліда.
     *
     * @param Lead $lead
     * @return View
     */
    public function edit(Lead $lead): View
    {
        return view('admin.leads.edit', ['lead' => $lead]);
    }

    /**
     * Оновлює існуючого ліда в базі даних.
     *
     * @param StoreRequest $request
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Lead $lead): RedirectResponse
    {
        $data = $request->validated();
        $lead->update($data);

        return redirect()->back();
    }

    /**
     * Видаляє конкретного ліда з бази даних.
     *
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        Cache::forget('statistic');

        return redirect()->back();
    }
}
