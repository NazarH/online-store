<?php

namespace App\View\Components;

use App\Facades\Currency;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $currencies;

    public function __construct()
    {
        $this->currencies = Currency::show();
    }

    public function render(): View
    {
        return view('components.navbar', ['currencies' => $this->currencies]);
    }
}
