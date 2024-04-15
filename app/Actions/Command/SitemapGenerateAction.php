<?php

namespace App\Actions\Command;

use App\Models\Article;
use App\Models\Category;
use App\Models\StaticPage;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

class SitemapGenerateAction
{
    use AsAction;

    private array $clientIndexRoutes = [
        'client.basket.index',
        'client.catalog.index',
        'client.articles.index',
        'client.search',
        'login',
        'register',
        'client.order.success',
    ];

    /**
     * Генерує файли sitemap.xml для індексації веб-сторінок пошуковими системами.
     *
     * @return void
     */
    public function handle(): void
    {
        $sitemap = Sitemap::create();

        $categories = Category::query()->with('products');
        $articles = Article::query();
        $pages = StaticPage::query();


        foreach ($this->clientIndexRoutes as $route) {
            $sitemap->add(Url::create(route($route))
                ->setPriority(0.5)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        }

        $categories->chunk(50, function($categories) use ($sitemap){
            foreach ($categories as $category) {
                $sitemap->add(
                    Url::create("/catalog/$category->slug")
                        ->setPriority(1.0)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                );

                foreach ($category->products as $product) {
                    $sitemap->add(
                        Url::create("/catalog/$category->slug/$product->slug")
                            ->setPriority(0.5)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    );
                }
            }
        });

        $articles->chunk(25, function ($articles) use ($sitemap) {
            foreach ($articles as $article) {
                $sitemap->add(
                    Url::create("/articles/$article->slug")
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                );
            }
        });

        $pages->chunk(5, function($pages) use ($sitemap) {
            foreach ($pages as $page) {
                $sitemap->add(
                    Url::create("/pages/$page->slug")
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                );
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
