<?php

namespace App\Http\Requests\Category;
use App\Http\Requests\DefaultRequest;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    use DefaultRequest;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'icon_path' => 'nullable|file|image|max:2048',
            'category_group_id' => 'required|integer',
            'sort_order' => [
                'required',
                'integer',
                Rule::unique('categories')->ignore($this->category)
            ]
        ];
    }
}
