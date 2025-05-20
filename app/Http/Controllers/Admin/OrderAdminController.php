<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function pending()
    {
        return view("admin.order.order", [
            'title' => "Đơn hàng đang chờ duyệt",
            'orders' => Order::where('status', 'pending')->with("orderitems.product")->orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function processing()
    {
        return view("admin.order.order", [
            'title' => "Đơn hàng đang đóng",
            'orders' => Order::where('status', 'processing')->with("orderitems.product")->orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function markAsProcessing($id)
    {
        // Tìm review theo ID
        $order = Order::findOrFail($id);
    
        // Cập nhật trạng thái của review thành "replied"
        $order->status = 'processing';
    
        // Lưu các thay đổi vào database
        $order->save();
    
        // Chuyển hướng lại trang review chưa phản hồi và thông báo
        return redirect()->route('admin.order.pending')->with('success', 'Đơn hàng đã đánh dấu chuẩn bị.');
    }

    public function shipped()
    {
        return view("admin.order.order", [
            'title' => "Đơn hàng đang giao",
            'orders' => Order::where('status', 'shipped')->with("orderitems.product")->orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function markAsShipped($id)
    {
        // Tìm review theo ID
        $order = Order::findOrFail($id);
    
        // Cập nhật trạng thái của review thành "replied"
        $order->status = 'shipped';
    
        // Lưu các thay đổi vào database
        $order->save();
    
        // Chuyển hướng lại trang review chưa phản hồi và thông báo
        return redirect()->route('admin.order.processing')->with('success', 'Đơn hàng đã đánh dấu đang giao');
    }

    public function completed()
    {
        return view("admin.order.order", [
            'title' => "Đơn hàng đã giao thành công",
            'orders' => Order::where('status', 'completed')->with("orderitems.product")->orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function markAsCompleted($id)
    {
        // Tìm review theo ID
        $order = Order::findOrFail($id);
    
        // Cập nhật trạng thái của review thành "replied"
        $order->status = 'completed';
    
        // Lưu các thay đổi vào database
        $order->save();
    
        // Chuyển hướng lại trang review chưa phản hồi và thông báo
        return redirect()->route('admin.order.shipped')->with('success', 'Đơn hàng đã đánh dấu giao thành công');
    }

    public function canceled()
    {
        return view("admin.order.order", [
            'title' => "Đơn hàng đã hủy",
            'orders' => Order::where('status', 'canceled')->with("orderitems.product")->orderBy('updated_at', 'desc')->paginate(10),
        ]);
    }

    public function markAsCanceled($id)
    {
        // Tìm review theo ID
        $order = Order::findOrFail($id);
    
        // Cập nhật trạng thái của review thành "replied"
        $order->status = 'canceled';
    
        // Lưu các thay đổi vào database
        $order->save();
    
        // Chuyển hướng lại trang review chưa phản hồi và thông báo
        return redirect()->route('admin.order.pending')->with('success', 'Đơn hàng đã đánh dấu hủy');
    }
}
