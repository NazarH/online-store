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
    /**
     * Показує список статей.
     *
     * @param CurrencyService $service
     * @return View
     */
    public function index(CurrencyService $service): View
    {
        $articles = Article::query()->with('user')->paginate(10);

        return view('admin.news.index', ['articles' => $articles]);
    }

    /**
     * Показує форму для створення нової статті.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Зберігає нову статтю в базі даних.
     *
     * @param StoreRequest $request
     * @param ArticleStoreAction $action
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, ArticleStoreAction $action): RedirectResponse
    {
        $data = $request->validated();

        $action->handle($data);

        return redirect()->route('admin.news.index');
    }

    /**
     * Показує форму для редагування конкретної статті.
     *
     * @param Article $article
     * @return View
     */
    public function edit(Article $article): View
    {
        return view('admin.news.edit', ['article' => $article]);
    }

    /**
     * Оновлює існуючу статтю в базі даних.
     *
     * @param StoreRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(StoreRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        $article->update($data);

        if (!empty($data['seo'])) {
            $article->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->route('admin.news.index');
    }

    /**
     * Видаляє конкретну статтю з бази даних.
     *
     * @param Article $article
     * @return RedirectResponse
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.news.index');
    }
}
