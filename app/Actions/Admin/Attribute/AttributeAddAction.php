<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Attribute;
use App\Models\Property;

class AttributeAddAction
{
    /**
     * Створює нову властивість для вказаного атрибута на основі наданих даних.
     *
     * @param array $data Дані нової властивості.
     * @param Attribute $attribute Атрибут, для якого створюється властивість.
     * @return void
     */
    public function handle(array $data, Attribute $attribute): void
    {
        $data['attribute_id'] = $attribute->id;

        Property::create($data);
    }
}
