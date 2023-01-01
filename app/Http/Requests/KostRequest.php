<?php

namespace App\Http\Requests;

use App\Helpers\ResponseJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class KostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
            'city', => 'required',
            'address', => 'required',
            'phone', => 'required',
            'location', => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
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