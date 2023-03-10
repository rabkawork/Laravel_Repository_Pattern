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
            // 'user_id' => 'required',
            'name' => 'required|max:50',
            'city' => 'required|max:30',
            'address' => 'required|max:30',
            'phone' => 'required|max:13',
            'location' => 'required|max:150',
            'description' => 'required',
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
            ResponseJson::responseBadOrError('Kost invalid',$validator->errors(), 400)
        );
    }
}
