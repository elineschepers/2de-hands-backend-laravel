<?php

namespace App\Http\Requests\Offers;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
            'price' => 'required|numeric|min:0|max:100',
            'courses' => 'required|array',
            'courses.*' => 'uuid|exists:courses,uuid'
        ];
    }
}
