<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::paginate(10);

        return view('client.articles.articles', ['articles' => $articles]);
    }

    public function single(Request $request): Vieww
    {
        $article = Article::where('slug', '=', $request->slug)->first();
        $comments = Comment::where('article_id', '=', $article->id)->paginate(10);

        return view('client.articles.article', ['article' => $article, 'comments' => $comments]);
    }
}
