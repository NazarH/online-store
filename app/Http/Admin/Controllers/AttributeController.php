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
    public function index(): View
    {
        $attributes = Attribute::paginate(10);

        return view('admin.attributes.index', ['attributes' => $attributes]);
    }

    public function create(): View
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.attributes.create', ['categories' => $categories]);
    }

    public function store(StoreRequest $request, AttributeStoreAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data);

        return redirect()->route('admin.attributes.index');
    }

    public function edit(Attribute $attribute): View
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.attributes.edit', [
            'attribute' => $attribute, '
            categories' => $categories
        ]);
    }

    public function update(UpdateRequest $request, Attribute $attribute, AttributeUpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data, $attribute);

        return redirect()->route('admin.attributes.index');
    }

    public function add(AddRequest $request, Attribute $attribute, AttributeAddAction $action): RedirectResponse
    {
        $data = $request->validated();
        $action->handle($data, $attribute);

        return redirect()->route('admin.attributes.edit', $attribute->id);
    }

    public function destroy(Attribute $attribute, AttributeDestroyAction $action): RedirectResponse
    {
        $action->handle($attribute);

        return redirect()->route('admin.attributes.index');
    }
}
