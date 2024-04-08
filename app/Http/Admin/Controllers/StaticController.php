<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Static\StaticStoreAction;
use App\Actions\Admin\Static\StaticUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Static\StoreRequest;
use App\Http\Requests\Static\UpdateRequest;
use App\Models\StaticPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticController extends Controller
{
    public function index(): View
    {
        $staticPages = StaticPage::paginate(10);

        return view('admin.static.index', ['staticPages' => $staticPages]);
    }

    public function create(): View
    {
        return view('admin.static.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        StaticPage::create($data);

        return redirect()->route('admin.static.index');
    }

    public function edit(StaticPage $page): View
    {
        return view('admin.static.edit', ['page' => $page]);
    }

    public function update(UpdateRequest $request, StaticPage $page): RedirectResponse
    {
        $data = $request->validated();

        $page->fill($data)->save();

        return redirect()->route('admin.static.index');
    }

    public function destroy(StaticPage $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.static.index');
    }

    public function upload(Request $request): JsonResponse
    {
        $url = asset('storage/'.$request->file('upload')->store('images', 'public'));

        $response = [
            'uploaded' => true,
            'url' => $url
        ];

        return response()->json($response);
    }
}
