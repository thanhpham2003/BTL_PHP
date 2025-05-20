<?php 
namespace App\Http\Services\Slider;
use App\Models\Slider;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class SliderService{

    public function store(array $data): Slider|bool
    {
        DB::beginTransaction();
        try{
            $slider = Slider::create([
                'name' => $data["name"] ?? "",
                'url' => $data["url"] ?? "",
                'thumb' => $data["thumbPath"] ?? "",
                'sort_by' => $data["sort_by"],
                'active' => $data["active"] ?? "",
                'description' => $data['description'] ?? ""
            ]);
            DB::commit();
            return $slider;
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
    
    public function get(array $conditions = []){
        $query = Slider::query();
        if(!empty($conditions["name"])){
            $query->where("name", "LIKE", "%".$conditions['name']."%");
        }
        return $query->orderByDesc($conditions["orderBy"] ?? "id")->paginate($conditions["limit"] ?? 10, page:$conditions["page"] ?? 1);
    }
    public function destroy($request)
    {
        try{
            $slider = Slider::find($request->input('id'));
            if($slider){
                if($slider->thumb && file_exists(storage_path('app/public/' . $slider->thumb))){
                    unlink(storage_path('app/public/' . $slider->thumb));
                }
                $slider->delete();
                return true;
            }
            return false;
        }catch(\Exception $err){
            Log::error('Lỗi xóa slider: ' . $err->getMessage());
            return false;
        }
    }
    public function update($request, $slider)
    {
        try {
            $data = $request->except('_token', '_method', 'sizes');
            // Nếu không có thumb mới, giữ lại thumb cũ
            $data["thumb"] = $request->thumb_url;
            $slider->fill($data);
            $slider->save();
            
            return true;
        } catch (\Exception $err) {
            Log::error('Error Update Slider: ' . $err->getMessage());
            return false;
        }
    }
}
?>