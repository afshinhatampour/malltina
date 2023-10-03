<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title'                  => 'required|string|min:2|max:256',
            'price'                  => 'required|integer|between:1,1000000',
            'variations'             => 'required|array',
            'variations.*.id'        => 'required|exists:variations,id',
            'variations.*.option_id' => 'required|exists:options,id'
        ];
    }
}
