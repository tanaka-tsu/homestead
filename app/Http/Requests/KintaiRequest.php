<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KintaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'date' => 'required',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'title.required' => 'タイトルは必須です',
    //         'detail.required' => '詳細は必須です',
    //     ];
    // }
}
