<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Business\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::getInstance(auth("frontend")->id());
        /**
         * Cap nhat lai thong tin san pham
         */
        $cart->refresh();
        // Kiểm tra giỏ hàng có sản phẩm không
        // Tạo đơn hàng
        DB::transaction(function() use($request, $cart){
            $order = Order::create([
                'user_id'         => Auth::id() ?? null, // Nếu khách chưa đăng nhập
                'customer_name'   => $request->name,
                'customer_phone'  => $request->phone,
                'customer_address'=> $request->address,
                'status'          => 'pending',
                'total_price'     => $cart->rawTotal(),
                'payment_method'  => $request->payment_method,
            ]);
    
            // Lưu từng sản phẩm vào bảng order_items
            foreach ($cart->content() as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product->id,
                    'quantity'   => $item->quantity,
                    'size_id'    => $item->sizeId,
                    'price'      => $item->product->price_sale ?? $item->product->price,
                ]);
            }
    
        });
        // // Xóa giỏ hàng sau khi đặt hàng thành công
        $cart->destroy();

    }
}

