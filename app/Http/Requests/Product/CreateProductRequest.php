<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        //'name', 'in_stock', 'sold', 'total_profit', 'rate'
        return [
            'name' => 'required',
            'in_stock' => 'numeric',
            'sold' => 'numeric',
            'total_profit' => 'numeric',
            'rate' => 'digits_between:0.0,5.0'
        ];
    }
}
