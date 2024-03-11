<?php

namespace App\Http\Requests\CategoryGroup;
use Illuminate\Validation\Rule;
use App\Http\Requests\DefaultRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    use DefaultRequest;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name_en' => 'required|string|max:255',
            'sort_order' => [
                'required',
                'integer',
                Rule::unique('category_groups')->ignore($this->category_group)
            ]
        ];
    }
}
