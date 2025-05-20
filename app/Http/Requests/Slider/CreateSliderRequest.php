<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'unique:sliders,name'
            ],
            'thumb' => 'required|image|mimes:jpeg, png, jpg, gif|max:2048',
            'url' => 'required',
        ];
        return $rules;
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unique' => 'Tên slider đã tồn tại',
            'thumb.required' => 'Ảnh không được để trống',
            'thumb.image' => 'File phải là ảnh',
            'thumb.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumb.max' => 'Kích thước ảnh tối đa là 2MB',
            'url.required' => 'Đường dẫn không được để trống'
        ];
    }
}
