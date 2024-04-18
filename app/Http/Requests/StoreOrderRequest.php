<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'sex' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'sex' => ['required' => 'Bạn chưa chọn giới tính'],
            'name' => ['required' => 'Bạn chưa nhâp tên'],
            'phone' => ['required' => 'Bạn chưa nhập số điện thoại'],
        ];
    }
}
