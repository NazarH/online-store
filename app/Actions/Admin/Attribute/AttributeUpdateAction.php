<?php

namespace App\Actions\Admin\Attribute;

class AttributeUpdateAction
{
    public function handle($data, $attribute)
    {
        $attribute->update([
            'name' => $data['name']
        ]);
        $attribute->categories()->sync($data['category_ids']);
    }
}
