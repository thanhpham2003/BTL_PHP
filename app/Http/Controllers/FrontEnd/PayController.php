<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Bills;
use Illuminate\Http\Request;
use App\Http\Business\Cart;
use App\Models\Size;

class PayController extends Controller
{
    // Load checkout form payment
    public function checkoutForm(Request $request)
    {   
        $customer = [
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'note' => $request->input('note'),
        ];
        $customer['total'] = $request->input('total');

        // $cart = $request->input('cart', []);
        $cart = Cart::getInstance(auth("frontend")->id());
        
        // add order to database
        $order = Order::create([
            'user_id' => $customer['user_id'],
            'customer_name' => $customer['name'],
            'customer_phone' => $customer['phone'],
            'customer_address' => $customer['address'],
            'status' => 'pending',
            'total_price' => $customer['total'],
            'payment_method' => 'Momo'
        ]);
        $cartItems = $cart->content();
        foreach ($cart->content() as $item) {

            // add order item to database
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'size_id' => $item->sizeId,
                'price' => $item->product->price_sale ?? $item->product->price,
            ]);

            $product_name = Product::find($item->product->id)->name;
            $product_size = Size::find($item->sizeId)->name;

            // add bill to database
            $bills =  Bills::create([
                'user_id' => $customer['user_id'],
                'customer_name' => $customer['name'],
                'phone' => $customer['phone'],
                'address' => $customer['address'],
                'total_amount' => $cart->rawTotal(),
                'products' => [
                    'product_name' => $product_name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price_sale ?? $item->product->price,
                    'size' => $product_size,
                ],
                'payment_method' => 'online',
                'note' => $customer['note'],
                'order_id' => $order->id,
            ]);
        }
        $menus = Menu::all();
        
        // Xoá giỏ hàng sau khi đặt hàng thành công
        $cart->destroy();

        return view('frontend.pay.checkoutConfirm', [
            'customer' => $customer,
            'cart' => $cartItems,
            'title' => 'Xác nhận thanh toán',
            'menus' => $menus,
            'product_size' => $product_size
        ]);
    }

    // payment with momo 
    public function createPayment(Request $request)
    {
        $dataOrder = $request->all();

        $endpoint = config('services.momo.endpoint');
        $partnerCode = config('services.momo.partner_code');
        $accessKey = config('services.momo.access_key');
        $secretKey = config('services.momo.secret_key');
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $dataOrder['total'] * 1000; 
        $orderId = time() . "";
        $redirectUrl = config('services.momo.redirect_url');
        $ipnUrl = config('services.momo.ipn_url');
        $requestId = time() . "";
        $requestType = "payWithATM";
        // $requestType = "captureWallet";
        $extraData = ""; 

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi',
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        $res = json_decode($result, true);
        curl_close($ch);

        if (isset($res['payUrl'])) {
            return redirect($res['payUrl']);
        }
        return response()->json($res);
    }


    // return redirect success and failed
    public function return(Request $request)
    {
        if ($request->query('resultCode') == '0') {
            return view('frontend.pay.success');
        }

        return view('frontend.pay.failed');
    }

    public function ipn(Request $request)
    {
        // Xử lý webhook tại đây (nếu muốn)
        return response()->json(['message' => 'IPN received']);
    }
    
}
