<?php

namespace App\Http\Repository;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class MenuRepository
{
    // get menu items
    public function getMenu()
    {
        return Menu::all();
    }

    // get user info
    public function getUserInfo() 
    {
        $user = Auth::guard('frontend')->user();
        return $user;
    }

    // get order
    public function getOrder()
    {
        $user = Auth::guard('frontend')->user();
        $order = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return $order;
    }

    // huỷ đơn hàng
    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->status = 'canceled';
        $order->save();
    }
}