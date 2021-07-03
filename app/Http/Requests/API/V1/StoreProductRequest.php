<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'=>'required|unique:products|max:50',
            'description'=>'max:300',
            'monthly_rent'=>'between:0,99.99',
            'refundable_deposit'=>'between:0,99.99',
            'category_id'=>'required|integer'
        ];
    }
}
