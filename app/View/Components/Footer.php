<?php

namespace App\View\Components;

use App\Models\StaticPage;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $pages;

    public function __construct()
    {
        $this->pages = StaticPage::get();
    }

    public function render(): View
    {
        return view('components.footer', ['pages' => $this->pages]);
    }
}
