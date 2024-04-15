<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Category\CategoryOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Показує список категорій.
     *
     * @return View
     */
    public function index(): View
    {
        $categories = Category::get();

        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Показує форму для створення нової категорії.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Зберігає нову категорію в базі даних.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $category = Category::create($data);

        if (!empty($data['seo'])) {
            $category->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Показує форму для редагування конкретної категорії.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Оновлює існуючу категорію в базі даних.
     *
     * @param StoreRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->update($data);

        if (!empty($data['seo'])) {
            $category->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->route('admin.categories.index');
    }

    /**
     * Видаляє конкретну категорію з бази даних.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }

    /**
     * Обробляє запит на зміну порядку категорій.
     *
     * @param Request $request
     * @param CategoryOrderAction $action
     * @return JsonResponse
     */
    public function order(Request $request, CategoryOrderAction $action): JsonResponse
    {
        $this->validate($request, ['data' => 'required|array']);
        $action->handle($request->data);

        return response()->json(['message' => trans('success')], Response::HTTP_ACCEPTED);
    }
}
