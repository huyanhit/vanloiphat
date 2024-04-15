<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'    => ['required',' max:100'],
            'contact' => ['required',' max:255'],
            'content' => ['required',' max:5000'],
        ];
    }

    public function messages(){
       return[
           'name'    => ['required' => 'Bạn chưa nhập tên','max' => 'Tên phải ngắn hơn 100 ký tự'],
           'contact' => ['required' => 'Bạn chưa nhập điện thoại hoặc Email','max'=> 'Nội dung phải ngắn hơn 255 ký tự'],
           'content' => ['required' => 'Bạn chưa nhập nội dung cần liên hệ','max'=> 'Nội dung phải ngắn hơn 5000 ký tự'],
       ];
    }
}
