<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'model_number' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'product_code' => 'nullable|string|max:255', // Added validation for product_code
            'status_id' => 'required|exists:product_statuses,id', // Changed 'status' to 'status_id' to match the foreign key
            'brand_id' => 'nullable|exists:brands,id', // Changed 'brand_id' to match the column name in the table
        ];
    }
}
