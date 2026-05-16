<?php

namespace App\Http\Requests\role;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            "name" => "required|string|max:255|min:3",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The name field is required.",
            "name.string" => "The name field must be a string.",
            "name.max" => "The name field must be at most 255 characters long.",
            "name.min" => "The name field must be at least 3 characters long.",
        ];
    }
}
