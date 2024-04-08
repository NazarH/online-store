<?php

namespace App\Actions\Admin\Attribute;

class AttributeDestroyAction
{
    public function handle($attribute)
    {
        $attribute->categories()->detach($attribute->belongsToCategories());
        $attribute->delete();
    }
}
