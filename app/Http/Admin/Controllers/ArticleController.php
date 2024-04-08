<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Admin\Article\ArticleStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Models\Article;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ArticleController extends Controller
{
    public function index(CurrencyService $service): View
    {
        $articles = Article::query()->with('user')->paginate(10);

        return view('admin.news.index', ['articles' => $articles]);
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(StoreRequest $request, ArticleStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        return redirect()->route('admin.news.index');
    }

    public function edit(Article $article): View
    {
        return view('admin.news.edit', ['article' => $article]);
    }

    public function update(StoreRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();
        $article->update($data);

        return redirect()->route('admin.news.index');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.news.index');
    }
}
