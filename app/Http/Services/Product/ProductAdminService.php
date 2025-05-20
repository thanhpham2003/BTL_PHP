<?php


namespace App\Http\Services\Product;


use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }


    public function insert($request)
    {

        try {
            $request->except('_token');
            Product::create($request->all());
            $thumbPath = $this->uploadThumb($request);
            $data = array_merge(
                $request->all(),
                ['thumb' => $thumbPath]
            );   
            Product::create($data);
            Session::flash('success', 'Thêm Sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Sản phẩm lỗi');
            Log::info($err->getMessage());
            return  false;
        }

        return  true;
    }

    public function get()
    {
        return Product::with('menu')
            ->orderByDesc('id')->paginate(15);
    }

    public function update($request, $product)
    {
        try {
            Log::info('Uploading product with data: ', $request->all());
            $product->fill($request->input());
            if($request->has('thumb')){
                $product->thumb = $request->input('thumb');
            }
            $product->save();
            Log::info('Product updated. New thumb value: ' . $product->thumb);
            Session::flash('success', 'Cập nhật thành công');
            return true;
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi vui lòng thử lại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        try{
            $product = Product::find($request->input('id'));
            if($product){
                if($product->thumb && file_exists(storage_path('app/public/' . $product->thumb))){
                    unlink(storage_path('app/public/' . $product->thumb));
                }
                $product->sizes()->detach();
                $product->delete();
                return true;
            }
            return false;
        }catch(\Exception $err){
            Log::error('Lỗi xóa sản phẩm: ' . $err->getMessage());
            return false;
        }
    }

    protected function uploadThumb($request){
        if($request->hasFile('thumb')){
            try{
                $name = $request->file('thumb')->getClientOriginalName();
                $pathFull = 'uploads/products/' . date("Y/m/d");
                $request->file('thumb')->storeAs('public/' . $pathFull, $name);
                return $pathFull . '/' . $name;
            }catch(\Exception $error){
                return false;
            }
        }
        return null;
    }
}