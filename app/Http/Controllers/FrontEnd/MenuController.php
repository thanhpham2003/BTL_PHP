<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Services\Menu\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(MenuService $menuService){
        $menus = $menuService->getAll();
        return view('components.menu-component', [
            'menus' => $menus
        ]);
    }
}
