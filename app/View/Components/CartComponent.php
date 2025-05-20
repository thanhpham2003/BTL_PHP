<?php

namespace App\View\Components;

use App\Http\Business\Cart;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartComponent extends Component
{
    public $cart = null;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->cart = Cart::getInstance(auth('frontend')->id());
        return view('components.cart-component', [
            'cart' => $this->cart,
        ]);
    }
}
