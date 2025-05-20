<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
                Rule::unique('products', 'name')->ignore($this->route('product'))
            ],
            'thumb' => 'nullable|image|mimes:jpeg, png, jpg, gif|max:2048',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|lt:price',
            'description' => 'required',
            'content' => 'required',
            "sizes" => ["required", "array", "min:1"],
            "sizes.*.size" => ["required_if:sizes,!=,[]", "exists:sizes,id"],
            "sizes.*.quantity" => ["required_if:sizes,!=,[]", "integer", "min:1"],
        ];
        // if($this->has('sizes')){
        //     $rules['sizes'] = 'required|array|min:1';
        //     $rules['sizes.*'] = 'in:S,M,L,XL,XXL';
        //     foreach($this->input('sizes', []) as $index => $size){
        //         $rules["quantities.$index"] = 'required|integer|min:1';
        //     }
        // }
        return $rules;
    }

    protected function prepareForValidation()
    {
        // Lọc ra các size được chọn (có checked)
        // $selectedSizes = collect($this->input('sizes', []))
        //     ->filter(function ($value, $key) {
        //         return !is_null($value);
        //     })->toArray();

        // // Lọc ra số lượng tương ứng với size được chọn
        // $quantities = collect($this->input('quantities', []))
        //     ->filter(function ($value, $key) use ($selectedSizes) {
        //         return array_key_exists($key, $selectedSizes) && !is_null($value) && $value > 0;
        //     })->toArray();

        // $this->merge([
        //     'sizes' => $selectedSizes,
        //     'quantities' => $quantities,
        //     "price" => str_replace('.', '', $this->input('price')),
        //     "price_sale" => $this->input('price_sale') ? str_replace('.', '', $this->input('price_sale')) : null
        // ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'thumb.required' => 'Ảnh không được để trống',
            'thumb.image' => 'File phải là ảnh',
            'thumb.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'thumb.max' => 'Kích thước ảnh tối đa là 2MB',
            'price.required' => 'Giá gốc không được để trống',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',
            'price_sale.numeric' => 'Giá khuyến mãi phải là số',
            'price_sale.min' => 'Giá khuyến mãi không được âm',
            'price_sale.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'description.required' => 'Mô tả không được để trống',
            'content.required' => 'Nội dung không được để trống',
            'sizes.required' => 'Vui lòng chọn ít nhất một size',
            'sizes.min' => 'Vui lòng chọn ít nhất một size',
            "sizes.*.quantity.required" => "Vui lòng nhập số lượng cho size đã chọn"
        ];
    }
    public function withValidator($validator)
    {
        // $validator->after(function ($validator) {
        //     // Kiểm tra xem có size nào được chọn không
        //     if (empty($this->input('sizes', []))) {
        //         $validator->errors()->add('sizes', 'Vui lòng chọn ít nhất một size');
        //     }

        //     // Kiểm tra số lượng cho các size được chọn
        //     $sizes = $this->input('sizes', []);
        //     $quantities = $this->input('quantities', []);

        //     foreach ($sizes as $sizeId => $value) {
        //         if (!isset($quantities[$sizeId]) || $quantities[$sizeId] < 1) {
        //             $validator->errors()->add(
        //                 'quantities.' . $sizeId,
        //                 'Vui lòng nhập số lượng cho size đã chọn'
        //             );
        //         }
        //     }
        // });
    }
}
