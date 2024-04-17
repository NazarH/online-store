<?php

namespace App\Http\Admin\Controllers;

use App\Actions\Command\SitemapGenerateAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class XmlGenerateController extends Controller
{
    /**
     * Генерує sitemap і перенаправляє адміністратора на домашню сторінку.
     *
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        SitemapGenerateAction::run();

        return redirect()->back();
    }
}
