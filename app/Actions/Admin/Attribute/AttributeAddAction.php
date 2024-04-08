<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Property;

class AttributeAddAction
{
    public function handle($data, $attribute)
    {
        $data['attribute_id'] = $attribute->id;

        Property::create($data);
    }
}
