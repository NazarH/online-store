<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Attribute;

class AttributeDestroyAction
{
    /**
     * Обробляє видалення атрибута з бази даних та від'єднання його від категорій.
     *
     * @param Attribute $attribute Атрибут, який потрібно видалити.
     * @return void
     */
    public function handle(Attribute $attribute): void
    {
        $attribute->categories()->detach($attribute->belongsToCategories());
        $attribute->delete();
    }
}
