<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            'author_id' => 'required',
            'title' => 'required|min:1|max:255',
            'description' => 'required|min:1|max:255',
            'release_date' => 'required|date',
            'isbn' => 'required',
            'format' => 'required',
            'number_of_pages' => 'required|integer|min:1',
        ];
    }
}
