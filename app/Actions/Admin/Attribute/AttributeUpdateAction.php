<?php

namespace App\Actions\Admin\Attribute;

use App\Models\Attribute;
use Lorisleiva\Actions\Concerns\AsAction;

class AttributeUpdateAction
{
    use AsAction;

    /**
     * Обробляє оновлення атрибута та його категорій.
     *
     * @param array $data Дані для оновлення атрибута.
     * @param Attribute $attribute Атрибут, який потрібно оновити.
     * @return void
     */
    public function handle(array $data, Attribute $attribute): void
    {
        $attribute->update([
            'name' => $data['name']
        ]);
        $attribute->categories()->sync($data['category_ids']);
    }
}
