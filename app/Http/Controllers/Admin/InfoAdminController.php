<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Info\UpdateInfoRequest;
use App\Http\Services\Info\InfoAdminService;
use App\Models\Info as Info;
use Illuminate\Http\Request;

class InfoAdminController extends Controller
{
    protected $infoAdminService;
    public function __construct(InfoAdminService $infoAdminService)
    {
        $this->infoAdminService = $infoAdminService;
    }
    public function index(Info $info){
        $info = Info::find(1);
        return view('admin.info.info', [
            'title' => 'Thông tin cửa hàng',
            'info' => $info
        ]);
    }

    public function update(Info $info, UpdateInfoRequest $request){
        $this->infoAdminService->update($request, $info);
        return redirect('/admin/infos/show');
    }
}
