<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\StaticStoreRequest;
use App\Http\Admin\Requests\StaticUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaticController extends Controller
{
    /**
     * Показує список статичних сторінок.
     *
     * @return View
     */
    public function index(): View
    {
        $staticPages = StaticPage::paginate(10);

        return view('admin.static.index', ['staticPages' => $staticPages]);
    }

    /**
     * Показує форму для створення нової статичної сторінки.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.static.create');
    }

    /**
     * Зберігає нову статичну сторінку в базі даних.
     *
     * @param StaticStoreRequest $request
     * @return RedirectResponse
     */
    public function store(StaticStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $page = StaticPage::create($data);

        if (isset($data['seo'])) {
            $page->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->route('static.index');
    }

    /**
     * Показує форму для редагування конкретної статичної сторінки.
     *
     * @param StaticPage $page
     * @return View
     */
    public function edit(StaticPage $page): View
    {
        return view('admin.static.edit', ['page' => $page]);
    }

    /**
     * Оновлює існуючу статичну сторінку в базі даних.
     *
     * @param StaticUpdateRequest $request
     * @param StaticPage $page
     * @return RedirectResponse
     */
    public function update(StaticUpdateRequest $request, StaticPage $page): RedirectResponse
    {
        $data = $request->validated();

        $page->fill($data)->save();

        if (isset($data['seo'])) {
            $page->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->back();
    }

    /**
     * Видаляє конкретну статичну сторінку з бази даних.
     *
     * @param StaticPage $page
     * @return RedirectResponse
     */
    public function destroy(StaticPage $page): RedirectResponse
    {
        $page->delete();

        return redirect()->back();
    }

    /**
     * Завантажує фото до БД.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
