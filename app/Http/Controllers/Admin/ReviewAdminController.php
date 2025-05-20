<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Services\Review\ReviewAdminService;

class ReviewAdminController extends Controller
{
    protected $reviewAdminService;
    public function __construct(ReviewAdminService $reviewAdminService)
    {
        $this->reviewAdminService = $reviewAdminService;
    }
    public function pending()
    {
        return view("admin.review.review", [
            'title' => "Đánh giá chưa phản hồi",
            'reviews' => Review::where('status', 'pending')->with("user")->orderBy('updated_at', 'desc')->paginate(10),
            'reviewCount' => Review::where('status', 'pending')->count()
        ]);
    }

    public function replied()
    {
        return view("admin.review.review", [
            'title' => "Đánh giá đã phản hồi",
            'reviews' => Review::where('status', 'replied')->orderBy('updated_at', 'desc')->paginate(10),
            'reviewCount' => Review::where('status', 'pending')->count() // Đếm số tin chưa phản hồi
        ]);
    }

    public function markAsReplied(Request $request, $id)
    {
        // Tìm review theo ID
        $review = Review::findOrFail($id);
    
        // Cập nhật trạng thái của review thành "replied"
        $review->status = 'replied';
    
        // Nếu có phản hồi từ admin, lưu phản hồi đó
        if ($request->has('admin_reply')) {
            $review->admin_reply = $request->input('admin_reply');
        }
    
        // Lưu các thay đổi vào database
        $review->save();
    
        // Chuyển hướng lại trang review chưa phản hồi và thông báo
        return redirect()->route('admin.review.pending')->with('success', 'Phản hồi đã được gửi và đánh dấu là đã phản hồi!');
    }
    

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->reviewAdminService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa đánh giá thành công'
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }

}
