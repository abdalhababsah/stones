<?php
namespace App\Http\Requests\AttributeGroup;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'sort_order' => [
                'required',
                'integer',
                Rule::unique('attribute_groups')->ignore($this->attribute_group)
            ],
        ];
    }
}

