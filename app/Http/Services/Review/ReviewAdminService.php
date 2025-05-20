<?php

namespace App\Http\Services\Review;

use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReviewAdminService{

    public function getAll(){
        return Review::orderbyDesc('id')->paginate(20);
    }
    public function destroy($request)
    {
        try{
            $review = Review::find($request->input('id'));
            if($review){
                $review->delete();
                return true;
            }
            return false;
        }catch(\Exception $err){
            Log::error('Lỗi xóa tin nhắn: ' . $err->getMessage());
            return false;
        }
    }

    public function getReviewAdminCount() {
        return Review::where('status', 'pending')->count();
    }

}

?>