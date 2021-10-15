<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|unique:Users|email',
            'username' => 'required|unique:Users|min:2',
            'password' => 'required|min:2',
            'house_number' => 'required',
            'street_name' => 'required',
            'city' => 'required',
            'postal_code' => 'required'
        ];
    }
}
