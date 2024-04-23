<?php

namespace App\Actions\Article;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class ArticleStoreAction
{
    use AsAction;

    /**
     * Створює нову статтю на основі наданих даних та пов'язує її з поточним користувачем.
     *
     * @param array $data Дані нової статті.
     */
    public function handle(array $data)
    {
        $data['user_id'] = Auth::user()->id;

        $article = Article::create($data);

        if (!empty($data['seo'])) {
            $article->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return $article;
    }
}
