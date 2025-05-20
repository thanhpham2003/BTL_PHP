<?php

namespace App\Http\Services\Info;

use App\Models\Info;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class InfoAdminService{

    public function getAll(){
        return Info::orderbyDesc('id')->paginate(20);
    }

    public function update($request, $info):bool{
        $info->address = (string)$request->input('address');
        $info->phone = (string)$request->input('phone');
        $info->email = (string)$request->input('email');
             
        $info->save();  

        Session::flash('success', 'Cập nhật thành công thông tin');
        return true;
    }

}

?>