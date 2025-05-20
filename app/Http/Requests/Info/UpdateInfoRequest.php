<?php

namespace App\Http\Requests\Info;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfoRequest extends FormRequest
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
            'phone' => [
                'required',
                'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'email' => [
                'required',
                'email'],
            'address' => [
                'required',
                'string',
                'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'phone.digits_between' => 'Số điện thoại phải có 10 hoặc 11 số.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];
    }
}
