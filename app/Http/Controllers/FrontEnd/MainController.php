<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Business\Cart;
use App\Http\Controllers\Controller;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Menu\MenuService;
use App\Models\Size;
use Illuminate\Support\Facades\DB; 
class MainController extends Controller
{
    public function index(SliderService $sliderService, ProductService $productService, MenuService $menuService)
    {
        $sliders = $sliderService->get();
        $products = $productService->getWithPagition(request()->all(), request("limit", 10), request("page", 1));
        $menus = $menuService->getParent();
        $sizes = Size::all();
    
        // Lấy danh sách size có sẵn cho từng sản phẩm
        $availableSizes = [];
        foreach ($products as $product) {
            $availableSizes[$product->id] = DB::table('product_sizes')
                ->where('product_id', $product->id)
                ->pluck('size_id')
                ->toArray();
        }
        
        // dd($availableSizes);
        return view('frontend.homepage.main', [
            'title' => 'Trang chủ',
            'sliders' => $sliders,
            'products' => $products,
            'menus' => $menus,
            'sizes' => $sizes,
            'availableSizes' => $availableSizes // Truyền danh sách size có sẵn vào View
        ]);
    }
    
}
