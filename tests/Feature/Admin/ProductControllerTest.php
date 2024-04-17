<?php

namespace Tests\Feature\Admin;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testIndexMethod()
    {
        $response = $this->get(route('admin.products.index'));
        $response->assertStatus(302);
    }
}
