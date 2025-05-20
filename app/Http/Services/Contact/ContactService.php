<?php

namespace App\Http\Services\Contact;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ContactService{

    public function getAll(){
        return Contact::orderbyDesc('id')->paginate(20);
    }

    public function create($request){
        try{
            $email = (string)$request->input('email');
            $message = (string)$request->input('message');
            $status = 'pending';
    
            Contact::create([
                'email' => $email,
                'message' => $message,
                'status' => $status
            ]);
    
 
        } catch (\Exception $err) {
            return false;
        }
        return true;
    }
    
}

?>