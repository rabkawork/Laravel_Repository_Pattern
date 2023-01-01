<?php

namespace App\Http\Requests;

use App\Helpers\ResponseJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'user_id' => 'required',
            'kost_id' => 'required|exists:kosts,id',
            'room_type' => 'required',
            'payment_type' => 'required',
            'availability' => 'required',
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
            ResponseJson::responseBadOrError('Room invalid',$validator, 400)
        );
    }
}
