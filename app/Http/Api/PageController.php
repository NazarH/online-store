<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Get a static page by slug.
     *
     * @api {get} /page/:slug Get Static Page
     * @apiName GetStaticPage
     * @apiGroup Pages
     *
     * @apiParam {String} slug Page slug.
     *
     */
    public function page(Request $request): PageResource
    {
        $page = StaticPage::where('slug', '=', $request->slug)->first();

        return new PageResource($page);
    }
}
