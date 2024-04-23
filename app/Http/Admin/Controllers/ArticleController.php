<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Article\ArticleStoreAction;
use App\Http\Admin\Requests\ArticleStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ArticleController extends Controller
{
    /**
     * Показує список статей.
     *
     * @return View
     */
    public function index(): View
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
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.news.create', ['categories' => $categories]);
    }

    /**
     * Зберігає нову статтю в базі даних.
     *
     * @param ArticleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $article = ArticleStoreAction::run($data);

        $article->mediaManage($request);

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
        $categories = Category::get()->pluck('name', 'id')->toArray();

        return view('admin.news.edit', ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Оновлює існуючу статтю в базі даних.
     *
     * @param ArticleStoreRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(ArticleStoreRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        $article->update($data);

        if (!empty($data['seo'])) {
            $article->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return redirect()->back();
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

        return redirect()->back();
    }
}
