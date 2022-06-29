<?php

namespace App\Http\Requests\Programs;

use App\Models\Program;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => 'required|array|min:1',
            'name.*' => 'nullable|max:40|string',
            // Dutch should be required if no other language is provided
            'name.nl' => [
                Rule::requiredIf(function () {
                    return !checkValidLocaleInRequest('name');
                })
            ]
        ];
    }
}
