<?php

namespace App\Http\Requests\posts;

use App\Rules\CheckUserCreateExceed3Posts;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|unique:posts|max:100',
            'description' => 'required',
            'user_id' => 'required',
            'image'=>'image|mimes:png,jpg'
        ];
    }
}