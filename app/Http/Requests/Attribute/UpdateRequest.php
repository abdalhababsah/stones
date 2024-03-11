<?php
namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

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
            'attribute_group_id' => 'required|integer',
            'sort_order' => [
                'required',
                'integer',
                Rule::unique('attributes')->ignore($this->id)

            ]
        ];
    }
}
