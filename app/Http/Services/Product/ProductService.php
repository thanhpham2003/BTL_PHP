<?php


namespace App\Http\Services\Product;

use App\Http\Enums\EnumStatus;
use App\Models\Product;
use App\Models\Size;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    const LIMIT = 16;

    public function getAll()
    {
        return Product::all(); // Lấy tất cả sản phẩm từ cơ sở dữ liệu.
    }

    public function getByMenus(array $menuIds) {
        return Product::whereIn('menu_id', $menuIds)->get();
    }
    

    public function get(int $page = 1)
    {
        return Product::select('id', 'name', 'size', 'price', 'price_sale', 'thumb')
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }

    public function getWithPagition(array $conditions, int $limit = 10, int $page = 1): LengthAwarePaginator
    {   
        $query = Product::query();
        if(!empty($conditions["name"])){
            $query->where("name", "LIKE", $conditions["name"]."%");
        }
        return $query->paginate($limit, page:$page);
    }

    public function show($id, array $relationShips = [])
    {
        return Product::where('id', $id)
            ->where('active', EnumStatus::ACTIVE->value)
            ->with($relationShips)
            ->firstOrFail();
    }

    public function store(array $data): Product|bool
    {
        DB::beginTransaction();
        try{
            $product = Product::create([
                'name' => $data["name"] ?? "",
                'description' => $data["description"] ?? "",
                'content' => $data["content"] ?? "",
                'menu_id' => $data["menu_id"] ?? "",
                'price' => $data["price"] ?? "",
                'price_sale' => $data["price_sale"],
                'thumb' => $data["thumbPath"] ?? "",
                'active' => $data["active"] ?? "",
            ]);
            if(!empty($data["sizes"])){
                
                $syncData = [];
                foreach($data["sizes"] as $dataSize){
                    $syncData[$dataSize["size"]] = ["quantity" => $dataSize["quantity"]];
                }
                $product->sizes()->sync($syncData);
            }
            DB::commit();
            return $product;
        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function more($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
    }

    public function update($request, $product)
    {
        try {
            $data = $request->except('_token', '_method', 'sizes');
            
            // Nếu không có thumb mới, giữ lại thumb cũ
            if (!isset($data['thumb'])) {
                $data['thumb'] = $product->thumb;
            }

            $product->fill($data);
            $product->save();
            
            return true;
        } catch (\Exception $err) {
            Log::error('Error Update Product: ' . $err->getMessage());
            return false;
        }
    }
}