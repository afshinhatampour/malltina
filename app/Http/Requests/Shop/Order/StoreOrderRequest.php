<?php

namespace App\Http\Requests\Shop\Order;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id'             => 'required|in:' . implode(',', Product::all()->pluck('id')->toArray()),
            'variations'             => 'required|array',
            'variations.*.id'        => 'required|exists:variations,id',
            'variations.*.option_id' => 'required|exists:options,id'
        ];
    }
}
