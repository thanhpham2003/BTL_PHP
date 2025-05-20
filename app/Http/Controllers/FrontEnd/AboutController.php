<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\About\AboutAdminService;
use App\Http\Services\Menu\MenuService;
class AboutController extends Controller
{
    public function index(AboutAdminService $aboutAdminService, MenuService $menuService){
        $menus = $menuService->getParent();
        $abouts = $aboutAdminService->get();
        return view("frontend.about.about", [
            'title' => 'Giới thiệu',
            'menus' => $menus,
            'abouts' => $abouts
        ]);
    }
}
