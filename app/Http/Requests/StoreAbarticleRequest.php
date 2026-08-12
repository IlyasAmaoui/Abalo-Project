<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbarticleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ab_name' => ['required', 'string', 'max:255'],
            'ab_description' => ['required', 'string', 'max:1000'],
            'ab_price' => ['required', 'numeric', 'min:0'],
            'image_path' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'ab_name.required'        => 'Please write a name for your article.',
            'ab_name.max'             => 'Name must be 255 characters or less.',
            'ab_description.required' => 'Please add a description.',
            'ab_price.required'       => 'Please set a price.',
            'ab_price.numeric'        => 'Price must be a number.',
            'ab_price.min'            => 'Price cannot be negative.',
            'image_path.required'       => 'Please upload an image.',
            'image_path.mimes'          => 'Image must be a JPEG or PNG file.',
            'image_path.max'            => 'Image must be smaller than 2MB.',
        ];
    }
}
