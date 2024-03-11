<?php
namespace App\Http\Requests\AttributeGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'sort_order' => 'required|integer|unique:attribute_groups,sort_order',
        ];
    }
}
