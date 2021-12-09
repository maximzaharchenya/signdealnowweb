<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealMarriedData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:65'],
            'surname' => ['required', 'string', 'max:65'],
            'number' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'country' => ['required', 'string', 'max:65'],
            'city' => ['required', 'string', 'max:65'],
            'address' => ['required', 'string', 'max:65'],
            'phone' => ['required', 'regex:/^[+]+/', 'max:20'],
            'email' => ['required', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
