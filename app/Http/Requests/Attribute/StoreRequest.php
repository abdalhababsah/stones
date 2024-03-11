<?php

namespace App\Http\Requests\Attribute;

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
            'names.*' => 'required|string|max:255',
            'orders.*' => 'required|numeric',
            'attribute_group_id' => 'required|integer',
        ];
    }
}
