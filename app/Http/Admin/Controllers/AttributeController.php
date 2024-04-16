<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Attribute\AttributeAddAction;
use App\Actions\Admin\Attribute\AttributeDestroyAction;
use App\Actions\Admin\Attribute\AttributeStoreAction;
use App\Actions\Admin\Attribute\AttributeUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\AddRequest;
use App\Http\Requests\Attribute\StoreRequest;
use App\Http\Requests\Attribute\UpdateRequest;
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
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        AttributeStoreAction::run($data);

        return redirect()->route('admin.attributes.index');
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
            'attribute' => $attribute, '
            categories' => $categories
        ]);
    }

    /**
     * Оновлює існуючий атрибут в базі даних.
     *
     * @param UpdateRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();
        AttributeUpdateAction::run($data, $attribute);

        return redirect()->route('admin.attributes.index');
    }

    /**
     * Додає значення до атрибуту.
     *
     * @param AddRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function add(AddRequest $request, Attribute $attribute): RedirectResponse
    {
        $data = $request->validated();
        AttributeAddAction::run($data, $attribute);

        return redirect()->route('admin.attributes.edit', $attribute->id);
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

        return redirect()->route('admin.attributes.index');
    }
}
