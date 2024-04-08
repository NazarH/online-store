<?php

namespace App\Actions\Admin\Brand;

use Illuminate\Support\Str;

class BrandUpdateAction
{
    public function handle($data, $brand)
    {
        $data['slug'] = Str::slug($data['name']);

        $brand->update($data);
    }
}
