<?php

namespace App\Http\User\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Показує список статей з пагінацією.
     *
     * @return View
     */
    public function index(): View
    {
        $articles = Article::paginate(10);

        return view('client.articles.articles', ['articles' => $articles]);
    }

    /**
     * Показує окрему статтю разом з коментарями до неї.
     *
     * @param Request $request
     * @return View
     */
    public function single(Request $request): View
    {
        $article = Article::where('slug', '=', $request->slug)->first();

        $comments = Comment::where('article_id', '=', $article->id)->paginate(10);

        $images = $article->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        });

        return view('client.articles.article', ['article' => $article, 'comments' => $comments, 'images' => $images]);
    }
}
