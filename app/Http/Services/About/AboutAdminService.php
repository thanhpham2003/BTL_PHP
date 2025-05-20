<?php 
namespace App\Http\Services\About;
use App\Models\About;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class AboutAdminService{

    public function store(array $data): About|bool
    {
        DB::beginTransaction();
        try{
            $about = About::create([
                'name' => $data["name"] ?? "",
                'content' => $data["content"] ?? "",
                'thumb' => $data["thumbPath"] ?? "",
            ]);
            DB::commit();
            return $about;
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
    
    public function get(array $conditions = []){
        $query = About::query();
        if(!empty($conditions["name"])){
            $query->where("name", "LIKE", "%".$conditions['name']."%");
        }
        return $query->orderByDesc($conditions["orderBy"] ?? "id")->paginate($conditions["limit"] ?? 10, page:$conditions["page"] ?? 1);
    }
    public function destroy($request)
    {
        try{
            $about = About::find($request->input('id'));
            if($about){
                if($about->thumb && file_exists(storage_path('app/public/' . $about->thumb))){
                    unlink(storage_path('app/public/' . $about->thumb));
                }
                $about->delete();
                return true;
            }
            return false;
        }catch(\Exception $err){
            Log::error('Lỗi xóa giới thiệu: ' . $err->getMessage());
            return false;
        }
    }
    public function update($request, $about)
    {
        try {
            $data = $request->except('_token', '_method', 'sizes');
            // Nếu không có thumb mới, giữ lại thumb cũ
            $data["thumb"] = $request->thumb_url;
            $about->fill($data);
            $about->save();
            
            return true;
        } catch (\Exception $err) {
            Log::error('Error Update About: ' . $err->getMessage());
            return false;
        }
    }
}
?>