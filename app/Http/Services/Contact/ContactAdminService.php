<?php

namespace App\Http\Services\Contact;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ContactAdminService{

    public function getAll(){
        return Contact::orderbyDesc('id')->paginate(20);
    }

    public function destroy($request)
    {
        try{
            $contact = Contact::find($request->input('id'));
            if($contact){
                $contact->delete();
                return true;
            }
            return false;
        }catch(\Exception $err){
            Log::error('Lỗi xóa tin nhắn: ' . $err->getMessage());
            return false;
        }
    }

    public function getMessageCount(){
        return Contact::where('status', 'pending')->count();
    }
}

?>