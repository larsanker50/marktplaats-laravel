<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest
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
            'title' => 'required',
            'body' => 'required',
            'rubric' => 'required_without:new_rubric|array|nullable',
            'new_rubric' => 'required_without:rubric|nullable|',
            'status' => 'nullable|string',
            'premium' => 'nullable|string'
        ];
    }
}
