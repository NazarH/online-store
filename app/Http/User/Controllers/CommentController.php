<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();
        $data['article_id'] = $article->id;

        $comment = Comment::create($data);
        Auth::user()->review()->attach($comment->id);

        return redirect()->route('client.articles.single', ['slug' => $article->slug]);
    }
}
