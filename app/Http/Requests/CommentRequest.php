<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'phone'   => ['required', 'min:8', 'max:50'],
            'name'    => ['required', 'max:100'],
            'rating'  => ['required'],
            'content' => ['required',' max:5000'],
        ];
    }

    public function messages(){
       return[
           'phone'   => ['required' => 'Bạn chưa nhập số điện thoại', 'min' => 'Điện thoại hơn 8 ký tự' ,'max' => 'Điện thoại ngắn hơn 50 ký tự'],
           'name'    => ['required' => 'Bạn chưa nhập tên', 'max' => 'Tên phải ngắn hơn 100 ký tự'],
           'rating'  => ['required' => 'Bạn chưa đánh giá'],
           'content' => ['required' => 'Bạn chưa nhập nội dung','max'=> 'Nội dung phải ngắn hơn 5000 ký tự'],
       ];
    }
}
