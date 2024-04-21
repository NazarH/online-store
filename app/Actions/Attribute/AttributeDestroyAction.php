<?php

namespace App\Actions\Attribute;

use App\Models\Attribute;
use Lorisleiva\Actions\Concerns\AsAction;

class AttributeDestroyAction
{
    use AsAction;

    /**
     * Обробляє видалення атрибута з бази даних та від'єднання його від категорій.
     *
     * @param Attribute $attribute Атрибут, який потрібно видалити.
     * @return void
     */
    public function handle(Attribute $attribute): void
    {
        $attribute->categories()->detach(array_keys($attribute->belongsToCategories()));
        $attribute->delete();
    }
}