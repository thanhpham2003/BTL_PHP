<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\UploadService;
use App\Models\Product;
use App\Models\Menu;
use App\Models\Size;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductAdminController extends Controller
{
    protected $productService;
    public function __construct(ProductAdminService $productService){
        $this->productService = $productService;
    }

    public function index(ProductService $service)
    {
        return view('admin.product.list', [
            'title' => 'Danh sách sản phẩm',
            "page" => request("page", 1),
            "limit" => request("limit", 1),
            'products' => $service->getWithPagition(request()->all(), request("limit", 10), request("page", 1))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::where('parent_id', '>', 0)->get();
       return view('admin.product.add', [
            'title' => 'Thêm sản phẩm mới',
            'menus' => $menus,
            'sizes' => Size::all()
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {

        try {
            $fileUploaded = app(UploadService::class)->store($request, "thumb");
            if(!$fileUploaded["error"] && !empty($fileUploaded["url"])){
                $request->merge(['thumbPath' => $fileUploaded["url"]]);
            }
            $product = app(ProductService::class)->store($request->all());
            
            if ($request->has('sizes')) {
                foreach ($request->sizes as $sizeId => $sizeData) {
                    if (isset($sizeData['active'])) {       
                        $product->sizes()->attach($sizeId, [
                            'quantity' => $sizeData['quantity'] ?? 0
                        ]);
                    }
                }
            }

            Session::flash('success', 'Thêm sản phẩm thành công');
            return redirect()->back();
    
        } catch (\Exception $err) {
            
            Session::flash('error', 'Thêm sản phẩm lỗi: ' . $err->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('sizes');
        $menus = Menu::where('parent_id', '>', 0)->get();
        return view('admin.product.edit', [
            'title' => 'Chỉnh sửa sản phẩm: ' .$product->name,
            'product' => $product, 
            'menus' => $menus,
            'sizes' => Size::all(),
            'products' => $this->productService->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        try {
            $thumb = $product->thumb; // Giữ ảnh cũ làm mặc định
            $product->load('sizes');
            Log::info('Request data:', $request->all());
            if ($request->hasFile('thumb')) {
                $fileUploaded = app(UploadService::class)->store($request, "thumb");
                
                if ($fileUploaded["error"]) {
                    throw new \Exception('Không thể upload file');
                }
                
                $thumb = $fileUploaded["url"];
            }

            // Merge thumb vào request
            $request->merge(['thumb' => $thumb]);

            // Cập nhật sản phẩm
            $this->productService->update($request, $product);

            // Xử lý sizes
            if ($request->has('sizes')) {
                Log::info('Current sizes before update: ', $product->sizes->toArray());
                Log::info('New sizes data:', $request->sizes);
                $product->sizes()->detach();
                foreach ($request->sizes as $sizeId => $sizeData) {
                    Log::info("Processing size id: $sizeId", $sizeData);
                    if (isset($sizeData['active']) && $sizeData['active']) {
                        $product->sizes()->attach($sizeId, [
                            'quantity' => $sizeData['quantity'] ?? 0
                        ]);
                    }
                }
                $product->load('sizes');
                Log::info('Sizes after update: ', $product->sizes->toArray());
            }else{
                Log::warning('No sizes data in request');
            }
            
            Session::flash('success', 'Cập nhật sản phẩm thành công');
            return redirect('/admin/products/list');
            
        } catch (\Exception $err) {
            Log::error('Update error: ' . $err->getMessage());
            Session::flash('error', 'Cập nhật sản phẩm thất bại: ' . $err->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->productService->destroy($request);
        if($result){
            return response()->json([
                'error' => false,
                'message' => 'Xóa sản phảm thành công'
            ]);
        }
        return response()->json([
            'error' =>true
        ]);
    }

}
