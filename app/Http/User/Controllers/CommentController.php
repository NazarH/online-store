<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\User\Requests\ReviewStoreRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Зберігає коментар для статті.
     *
     * @param ReviewStoreRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();
        $data['article_id'] = $article->id;

        $comment = Comment::create($data);
        Auth::user()->review()->attach($comment->id);

        return redirect()->route('client.articles.single', ['slug' => $article->slug]);
    }
}
