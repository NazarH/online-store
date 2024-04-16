<?php

namespace App\Actions\Admin\Product;

use App\Models\Photo;
use Lorisleiva\Actions\Concerns\AsAction;

class UploadFileAction
{
    use AsAction;

    /**
     * Зберігає зображення продукту та пов'язує його з відповідним продуктом.
     *
     * @param $files
     * @param int $id Ідентифікатор продукту, з яким пов'язані зображення
     * @return void
     */
    public function handle($files, int $id): void
    {
        if ($files) {
            foreach ($files as $file) {
                $path = $file->store('products', 'public');

                Photo::create([
                    'name' => basename($path),
                    'model_type' => 'products',
                    'model_id' => $id
                ]);
            }
        }
    }
}
