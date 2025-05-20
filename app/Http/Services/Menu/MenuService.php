<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class MenuService{
    public function getParent(){
        return Menu::where('parent_id', 0)->get();
    }
    public function getAll(){
        return Menu::orderbyDesc('id')->paginate(20);
    }
    public function getChildMenuIds($parentId) {
        return Menu::where('parent_id', $parentId)->pluck('id')->toArray();
    }
    
    public function create($request){
        try{
            $name = (string)$request->input('name');
            $parent_id = (int)$request->input('parent_id');

            if($parent_id > 0){
                $parentMenu = Menu::find($parent_id);
                if($parentMenu && $parentMenu->name === $name){
                    Session::flash('error', 'Tạo không thành công, tên danh mục mới không được trùng với danh mục cha');
                    return false;
                }

            }

            $existingMenu = Menu::where('name', $name)->where('parent_id', $parent_id)->first();
            if($existingMenu){
                Session::flash('error', 'Tạo không thành công, tên danh mục không được trùng nhau');
                return false;
            }
            
            $slug = $this->createSlug($request->input('name'));

            Menu::create([
                'name' => $name,
                'parent_id' => $parent_id,
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (string) $request->input('active'),
                'slug' => $slug
            ]);

            Session::flash('success', 'Tạo danh mục thành công');
        }catch(\Exception $err){
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function update($request, $menu):bool{
        if($request->input('parent_id') != $menu->id){
            $menu->parent_id = (int)$request->input('parent_id');
        }
        if ($request->input('parent_id') == $menu->id) {
            Session::flash('error', 'Không thể cập nhật vì tên danh mục và danh mục cha không được trùng nhau');
            return false;
        }
        $menu->name = (string)$request->input('name');
        $menu->description = (string)$request->input('description');
        $menu->content = (string)$request->input('content');

        if ($menu->id) {
            $menu->active = (string)$request->input('active');
            $children = Menu::where('parent_id', $menu->id)->get();
            foreach ($children as $child) {
                $child->active = $menu->active; // Đặt trạng thái active của danh mục con giống với danh mục cha
                $child->save(); // Lưu thay đổi
            }
        }  
             
        $menu->save();  

        Session::flash('success', 'Cập nhật thành công danh mục');
        return true;
    }

    public function destroy($request){
        $id = (int) $request->input('id');
        $menu = Menu::where('id', $request->input('id'))->first();
        if($menu){
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }

    public function createSlug($name) {
        $slug = Str::slug($name);
        $count = Menu::where('slug', $slug)->count();
        return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    }
}

?>