<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
        // 'name', 'number_of_products', 'total_items_in_stock', 'total_profit', 'total_items_sold'
        return [
            'name' => 'required',
            'number_of_products' => 'numeric',
            'total_items_in_stock' => 'numeric',
            'total_profit' => 'numeric',
            'total_items_sold' => 'numeric'

        ];
    }
}
