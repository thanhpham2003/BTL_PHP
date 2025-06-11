<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repository\MenuRepository;

class UserInfoController extends Controller
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    // tải trang thông tin cá nhân
    public function index()
    {
        $title = 'Thông tin cá nhân';
        $menus = $this->menuRepository->getMenu();
        $user = $this->menuRepository->getUserInfo();

        return view('frontend.info.userInfo', [
            'title' => $title,
            'menus' => $menus,
            'user' => $user,
        ]);
    }

    // tải trang đơn hàng của tôi
    public function myOrderIndex()
    {
        $title = 'Đơn hàng của tôi';
        $menus = $this->menuRepository->getMenu();
        $orders = $this->menuRepository->getOrder();

        return view('frontend.info.myOrder', [
            'title' => $title,
            'menus' => $menus,
            'orders' => $orders,
        ]);
    }

    // huỷ đơn hàng
    public function cancelOrder(Request $request)
    {
        $orderId = $request->id;
        $result = $this->menuRepository->cancelOrder($orderId);

        if ($result) {
            return redirect()->route('user.myOrder');
        }
    }
}
