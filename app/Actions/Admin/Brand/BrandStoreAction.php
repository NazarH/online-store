<?php

namespace App\Actions\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;

class BrandStoreAction
{
    public function handle($data)
    {
        $data['slug'] = Str::slug($data['name']);

        Brand::create($data);

    }
}
