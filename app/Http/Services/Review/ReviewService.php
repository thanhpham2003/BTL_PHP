<?php

namespace App\Http\Services\Review;

use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ReviewService{

    public function getAll(){
        return Review::orderbyDesc('id')->paginate(20);
    }

    public function getReviewCount(){
        return Review::count();
    }
}

?>