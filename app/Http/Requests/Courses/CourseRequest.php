<?php

namespace App\Http\Requests\Courses;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|array|min:1',
            'name.*' => 'nullable|max:40|string',
            // Dutch should be required if no other language is provided
            'name.nl' => [
                Rule::requiredIf(static function () {
                    return !checkValidLocaleInRequest('name');
                })
            ],
            'code' => 'required|array|min:1|max:10',
            'code.*' => 'required|string|max:10',
            'programs' => 'required|array',
            'programs.*' => 'uuid|exists:programs,uuid'
        ];
    }
}
