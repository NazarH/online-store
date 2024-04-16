<?php

namespace App\Actions\Admin\Article;

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
     * @return void
     */
    public function handle(array $data): void
    {
        $data['user_id'] = Auth::user()->id;

        $article = Article::create($data);

        if (!empty($data['seo'])) {
            $article->seo()->updateOrCreate(['tags' => $data['seo']]);
        }
    }
}
