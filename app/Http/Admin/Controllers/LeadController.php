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
    public function index(): View
    {
        $leads = Lead::query()->with('user')->paginate(10);

        return view('admin.leads.index', ['leads' => $leads]);
    }

    public function create(): View
    {
        return view('admin.leads.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Lead::create($data);

        Cache::forget('statistic');

        return redirect()->route('admin.leads.index');
    }

    public function edit(Lead $lead): View
    {
        return view('admin.leads.edit', ['lead' => $lead]);
    }

    public function update(StoreRequest $request, Lead $lead): RedirectResponse
    {
        $data = $request->validated();
        $lead->update($data);

        return redirect()->route('admin.leads.index');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        Cache::forget('statistic');

        return redirect()->route('admin.leads.index');
    }
}
