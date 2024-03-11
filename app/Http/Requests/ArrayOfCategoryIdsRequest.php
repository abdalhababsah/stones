<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ArrayOfCategoryIds;

class ArrayOfCategoryIdsRequest extends FormRequest
{
    use DefaultRequest;

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
     * @return array
     */
    public function rules(): array
    {
        return [
            'categories' => ['required', 'array', new ArrayOfCategoryIds()],
            // Add other validation rules for other fields if needed
        ];
    }
}
