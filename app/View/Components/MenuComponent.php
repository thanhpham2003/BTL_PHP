<?php

namespace App\View\Components;

use App\Http\Services\Menu\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MenuComponent extends Component
{

    public $orders;
    public $menus;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menus = resolve(MenuService::class)->getParent();
        $this->orders = Order::where('user_id', Auth::guard("frontend")->id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        
        return view('components.menu-component', [
            'orders' => $this->orders,
        ]);
    }
}
