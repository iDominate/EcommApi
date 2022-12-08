<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'alpha',
            'number_of_products' => 'numeric',
            'total_items_in_stock' => 'numeric',
            'total_profit' => 'numeric',
            'total_items_sold' => 'numeric'
        ];
    }
}
