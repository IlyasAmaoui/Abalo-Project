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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'        => 'Please write a name for your article.',
            'name.max'             => 'Name must be 255 characters or less.',
            'description.required' => 'Please add a description.',
            'price.required'       => 'Please set a price.',
            'price.numeric'        => 'Price must be a number.',
            'price.min'            => 'Price cannot be negative.',
            'image.required'       => 'Please upload an image.',
            'image.mimes'          => 'Image must be a JPEG or PNG file.',
            'image.max'            => 'Image must be smaller than 2MB.',
        ];
    }
}
