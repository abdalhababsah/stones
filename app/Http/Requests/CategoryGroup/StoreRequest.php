<?php

namespace App\Http\Requests\CategoryGroup;
use App\Http\Requests\DefaultRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use DefaultRequest;


    public function rules()
    {
        return [
            'name_en' => 'required|string|max:255',
            'sort_order' => 'required|integer|unique:category_groups,sort_order',
        ];
    }
}

