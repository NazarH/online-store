<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Attribute;
use App\Models\Property;

class AttributeStoreAction
{
    public function handle($data)
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
