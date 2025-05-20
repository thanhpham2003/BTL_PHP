<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateAboutRequest extends FormRequest
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
                Rule::unique('abouts', 'name')->ignore($this->route('about'))
            ],
            'thumb' => 'nullable|image|mimes:jpeg, png, jpg, gif|max:2048',
            'content' => 'required',
        ];
        return $rules;
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unique' => 'Tên giới thiệu đã tồn tại',
            'thumb.required' => 'Ảnh không được để trống',
            'thumb.image' => 'File phải là ảnh',
            'thumb.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumb.max' => 'Kích thước ảnh tối đa là 2MB',
            'content.required' => 'Mô tả không được để trống'
        ];
    }
}
