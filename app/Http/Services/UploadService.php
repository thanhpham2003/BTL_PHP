<?php


namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class UploadService
{
    public function store($request, $fieldName, string $folder = "products")
    {
        try {
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                
                // Kiểm tra file có hợp lệ
                if ($file->isValid()) {
                    $name = time() . '_' . $file->getClientOriginalName();
                    $pathFull = "uploads/$folder";
                    
                    $file->move(public_path($pathFull), $name);
                    
                    return [
                        'error' => false,
                        'url' => "/$pathFull/$name"
                    ];
                }
            }
            
            return [
                'error' => true,
                'url' => ''
            ];
            
        } catch (\Exception $error) {
            Log::error('Upload error: ' . $error->getMessage());
            return [
                'error' => true,
                'url' => ''
            ];
        }
    }
}
?>