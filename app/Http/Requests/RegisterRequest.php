<?php

namespace App\Http\Requests;

use App\Helpers\ResponseJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:20|unique:users',
            'password' => 'required|string|min:8',
            'permission' => 'required|numeric|between:1,2,3'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseJson::responseBadOrError('Registration invalid',$validator, 400)
        );
    }
}