<?php

namespace App\Http\Admin\Controllers;

use App\Actions\FilterAction;
use App\Http\Admin\Requests\LeadStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Показує список потенційних клієнтів (лідів).
     *
     * @return View
     */
    public function index(FilterAction $filter, array $sortBy = ['sortBy' => 'id']): View
    {
        $query = Lead::query();

        if (Request::all()) {
            $query = $filter->handle($query);
        }

        $field = Request::has('sortBy') ? Request::only(['sortBy']) : $sortBy;

        $this->sortLeads($field['sortBy']);

        $leads = $query
            ->orderBy($field['sortBy'], Session::get('leads'))
            ->with('user')
            ->paginate(10);

        return view('admin.leads.index', ['leads' => $leads]);
    }

    private function sortLeads(string $sortBy)
    {
        if ($sortBy !== 'id') {
            if (empty(Session::get('leads')) || Session::get('leads') === 'desc') {
                Session::put('leads', 'asc');
            } else if(Session::get('leads') === 'asc') {
                Session::put('leads', 'desc');
            }
        } else {
            Session::put('leads', 'asc');
        }
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
     * @param LeadStoreRequest $request
     * @return RedirectResponse
     */
    public function store(LeadStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Lead::create($data);

        Cache::forget('statistic');

        return redirect()->route('leads.index');
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
     * @param LeadStoreRequest $request
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function update(LeadStoreRequest $request, Lead $lead): RedirectResponse
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
