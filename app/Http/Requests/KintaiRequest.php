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
            'this_month' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'user_idは必須です',
            'this_month.required' => '年/月は必須です',
        ];
    }
}
