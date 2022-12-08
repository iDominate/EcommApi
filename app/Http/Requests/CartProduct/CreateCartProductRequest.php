<?php

namespace App\Http\Requests\CartProduct;

use App\Models\Cart;
use Illuminate\Foundation\Http\FormRequest;

class CreateCartProductRequest extends FormRequest
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
            'name' => 'required|exists:products,name',
            'product_unit_count' => 'required|numeric',
        ];
    }
}
