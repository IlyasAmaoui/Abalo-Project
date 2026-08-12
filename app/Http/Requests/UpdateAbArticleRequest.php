<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAbArticleRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ab_name' => ['required', 'string', 'max:80'],
            'ab_price' => ['required', 'integer', 'min:0'],
            'ab_description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'ab_name.required' => 'The article name is required.',
            'ab_name.string' => 'The article name must be a valid text.',
            'ab_name.max' => 'The article name may not be longer than 80 characters.',

            'ab_price.required' => 'The price is required.',
            'ab_price.integer' => 'The price must be a whole number.',
            'ab_price.min' => 'The price must be at least 0.',

            'ab_description.required' => 'The article description is required.',
            'ab_description.string' => 'The article description must be valid text.',
            'ab_description.max' => 'The article description may not be longer than 1000 characters.',

            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'The image may not be larger than 2 MB.',
        ];
    }
}
