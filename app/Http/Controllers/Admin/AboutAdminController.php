<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\About\CreateAboutRequest;
use App\Http\Requests\About\UpdateAboutRequest;
use App\Http\Services\UploadService;
use Illuminate\Support\Facades\Session;
use App\Http\Services\About\AboutAdminService;
use App\Models\About;
use Illuminate\Support\Facades\Log;

class AboutAdminController extends Controller
{
    protected $aboutAdminService;
    public function __construct(AboutAdminService $aboutAdminService)
    {
        $this->aboutAdminService = $aboutAdminService;
    }

    public function index(){
        return view('admin.about.list', [
            'title' => 'Danh sách giới thiệu',
            'abouts' => $this->aboutAdminService->get(request()->all())
        ]);
    }
    public function create()
    {
       return view('admin.about.add', [
            'title' => 'Thêm giới thiệu mới'
       ]);
    }

    public function store(CreateAboutRequest $request){
        try {
            $fileUploaded = app(UploadService::class)->store($request, "thumb");
            if(!$fileUploaded["error"] && !empty($fileUploaded["url"])){
                $request->merge(['thumbPath' => $fileUploaded["url"]]);
            } else {
                // Thêm thông báo lỗi nếu không tải lên được
                Session::flash('temp_image', $request->file('thumb')->getClientOriginalName());
                Session::flash('error', 'Lỗi tải lên hình ảnh: ' . $fileUploaded["message"]);
                return redirect()->back();
            }
            $about = app(AboutAdminService::class)->store($request->all());
            if ($about) {
                Session::flash('success', 'Thêm giới thiệu thành công');
            } else {
                Session::flash('error', 'Thêm giới thiệu thất bại, vui lòng kiểm tra lại thông tin.');
            }
            return redirect()->back();
    
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm giới thiệu lỗi: ' . $err->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->aboutAdminService->destroy($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa slider thành công'
            ]);
        }
        return response()->json([
            'error' =>true
        ]);
    }

    public function show(About $about){
        return view('admin.about.edit', [
            'title' => 'Chỉnh sửa giới thiệu',
            'about' => $about
        ]);
    }

    public function update(About $about, UpdateAboutRequest $request)
    {
        try {
            $thumb = $about->thumb; // Giữ ảnh cũ làm mặc định
            Log::info('Request data:', $request->all());
            if ($request->hasFile('thumb')) {
                $fileUploaded = app(UploadService::class)->store($request, "thumb");
                
                if ($fileUploaded["error"]) {
                    throw new \Exception('Không thể upload file');
                }
                
                $thumb = $fileUploaded["url"];
            }
            
            // Merge thumb vào request
            $request->merge(['thumb_url' => $thumb]);
            // Cập nhật sản phẩm
            $this->aboutAdminService->update($request, $about);
            
            Session::flash('success', 'Cập nhật giới thiệu thành công');
            return redirect('/admin/abouts/list');
            
        } catch (\Exception $err) {
            Log::error('Update error: ' . $err->getMessage());
            Session::flash('error', 'Cập nhật giới thiệu thất bại: ' . $err->getMessage());
            return redirect()->back();
        }
    }
}
