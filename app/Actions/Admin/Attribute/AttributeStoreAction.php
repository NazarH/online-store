<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Attribute;
use App\Models\Property;

class AttributeStoreAction
{
    /**
     * Обробляє створення нового атрибута та його властивостей.
     *
     * @param array $data Дані для створення атрибута та його властивостей.
     * @return void
     */
    public function handle(array $data): void
    {
        $attribute = Attribute::create([
            'name' => $data['name']
        ]);
        $attribute->categories()->sync($data['category_ids']);

        Property::create([
            'value' => $data['value'],
            'attribute_id' => $attribute->id
        ]);
    }
}
