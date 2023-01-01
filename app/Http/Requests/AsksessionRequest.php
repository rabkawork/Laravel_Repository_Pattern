<?php

namespace App\Http\Requests;

use App\Helpers\ResponseJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AsksessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'kost_id' => 'required|exists:kosts,id',
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
            ResponseJson::responseBadOrError('Ask session invalid',$validator->errors(), 400)
        );
    }
}
