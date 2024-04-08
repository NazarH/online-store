<?php

namespace App\Actions\Admin\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleStoreAction
{
    public function handle($data)
    {
        $data['user_id'] = Auth::user()->id;

        Article::create($data);
    }
}
