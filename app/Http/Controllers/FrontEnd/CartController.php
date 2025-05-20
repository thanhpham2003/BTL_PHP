<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Business\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = Cart::getInstance(auth("frontend")->id());
        // Sau viet vao validate
        $productId = $request->id;
        $sizeId = $request->size_id;
        $quantity = $request->quantity;
        $cart->addToCart($productId, $sizeId, $quantity);

        return response()->json([
            'cart_content' => view("frontend.cart.cart_content")->render(),
            'message' => 'Đã thêm vào giỏ hàng',
        ]);
    }

    // public removeCart()
    // {
    //     $cart = Cart::getInstance(auth("frontend")->id());
    //     $cart->removeCart();
    // }
    /**
     * Ssau nay cai validate can move vao trong FormRequest
     */
    public function updateCartItem(Request $request)
    {
        $request->validate([
            "rowId" => ["required"],
            "quantity" => ["required"]
        ]);
        $cart = Cart::getInstance(auth("frontend")->id());
        $row = $cart->updateCart($request->get("rowId"), $request->get("quantity"));

        return response()->json([
            'message' => 'Cap nhat gio hang thanh cong',
            'total' => $cart->total(),
            'row_total' => $row->total()
        ]);
    }

    public function viewCart(MenuService $menuService)
    {
        $cart = Cart::getInstance(auth("frontend")->id());
        $cart->refresh();
        $menus = $menuService->getParent();
        return view('frontend.cart.cartDetail', [
            'cart' => $cart,
            'title' => 'Chi tiết giỏ hàng',
            'menus' => $menus
        ]);
        
    }

    public function removeCart(Request $request)
    {
        $cart = Cart::getInstance(auth("frontend")->id());
        $rowId = $request->rowId;
        $success = $cart->removeCart($rowId);
        return response()->json([
            'cart_content' => view("frontend.cart.cart_content")->render(),
            'success' => $success,
            'total' => $cart->total()
        ]);
    }
    

}
