<?php

namespace App\Http\Requests;

use App\Trait\HasResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBukuRequest extends FormRequest
{

    use HasResponse;

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
            'title' => 'required|string|max:255|unique:bukus,title',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'years' => 'required|digits:4|integer',
            'isbn' => 'required|string|max:20|unique:bukus,isbn',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->toArray() as $key => $value) {
            $errors[$key] = $value[0];
        }
        throw new HttpResponseException($this->response(422,"Failed Validation", $errors));
    }
}