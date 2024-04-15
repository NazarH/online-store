<?php

namespace App\View\Components;

use App\Facades\Currency;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $currencies;

    /**
     * Створює новий екземпляр класу.
     */
    public function __construct()
    {
        $this->currencies = Currency::show();
    }

    /**
     * Відображає компонент.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.navbar', ['currencies' => $this->currencies]);
    }
}
