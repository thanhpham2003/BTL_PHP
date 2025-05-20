<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\CreateSliderRequest;
use App\Http\Requests\Slider\UpdateSliderRequest;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\UploadService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    public function index(){
        return view('admin.slider.list', [
            'title' => 'Danh sách slider',
            'sliders' => $this->sliderService->get(request()->all())
        ]);
    }

    public function create(){
        return view('admin.slider.add', [
            'title' => 'Thêm slider'
        ]);
    }

    public function store(CreateSliderRequest $request){
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
            $slider = app(SliderService::class)->store($request->all());
            if ($slider) {
                Session::flash('success', 'Thêm slider thành công');
            } else {
                Session::flash('error', 'Thêm slider thất bại, vui lòng kiểm tra lại thông tin.');
            }
            return redirect()->back();
    
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm slider lỗi: ' . $err->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->sliderService->destroy($request);
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

    public function show(Slider $slider){
        return view('admin.slider.edit', [
            'title' => 'Chỉnh sửa slider',
            'slider' => $slider
        ]);
    }

    public function update(Slider $slider, UpdateSliderRequest $request)
    {
        try {
            $thumb = $slider->thumb; // Giữ ảnh cũ làm mặc định
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
            $this->sliderService->update($request, $slider);
            
            Session::flash('success', 'Cập nhật slider thành công');
            return redirect('/admin/sliders/list');
            
        } catch (\Exception $err) {
            Log::error('Update error: ' . $err->getMessage());
            Session::flash('error', 'Cập nhật slider thất bại: ' . $err->getMessage());
            return redirect()->back();
        }
    }

}
