<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Info\InfoAdminService;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Services\Contact\ContactService;

class ContactController extends Controller
{
    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }
    public function index(MenuService $menuService, InfoAdminService $infoAdminService){
        $menus = $menuService->getParent();
        $infos = $infoAdminService->getAll();
        return view("frontend.contact.contact",[
            'title' => "Liên hệ",
            'menus' => $menus,
            'infos' => $infos
        ]);
    }

public function store(ContactRequest $request){
    try {
        $this->contactService->create($request);
        return response()->json(['status' => 'success', 'message' => 'Gửi tin nhắn thành công!']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']);
    }
}

    
    

}
