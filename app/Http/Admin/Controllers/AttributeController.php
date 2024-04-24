<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Attribute\AttributeAddAction;
use App\Actions\Attribute\AttributeDestroyAction;
use App\Actions\Attribute\AttributeStoreAction;
use App\Actions\Attribute\AttributeUpdateAction;
use App\Http\Admin\Requests\AttributeAddRequest;
use App\Http\Admin\Requests\AttributeStoreRequest;
use App\Http\Admin\Requests\AttributeUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttributeController extends Controller
{
    /**
     * Показує список атрибутів.
     *
     * @return View
     */
    public function index(): View
    {
        $attributes = Attribute::paginate(10);

        return view('admin.attributes.index', ['attributes' => $attributes]);
    }

    /**
     * Показує форму для створення нового атрибуту.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.attributes.create', ['categories' => $categories]);
    }

    /**
     * Зберігає новий атрибут в базі даних.
     *
     * @param AttributeStoreRequest $request
     * @return RedirectResponse
     */
    public function store(AttributeStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        AttributeStoreAction::run($data);

        return redirect()->route('attributes.index');
    }

    /**
     * Показує форму для редагування конкретного атрибуту.
     *
     * @param Attribute $attribute
     * @return View
     */
    public function edit(Attribute $attribute): View
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.attributes.edit', [
            'attribute' => $attribute, 'categories' => $categories
        ]);
    }

    /**
     * Оновлює існуючий атрибут в базі даних.
     *
     * @param AttributeUpdateRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(AttributeUpdateRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();
        AttributeUpdateAction::run($data, $attribute);

        return redirect()->back();
    }

    /**
     * Додає значення до атрибуту.
     *
     * @param AttributeAddRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function add(AttributeAddRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();
        AttributeAddAction::run($data, $attribute);

        return redirect()->route('attributes.edit', $attribute->id);
    }

    /**
     * Видаляє конкретний атрибут з бази даних.
     *
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        AttributeDestroyAction::run($attribute);

        return redirect()->back();
    }
}
