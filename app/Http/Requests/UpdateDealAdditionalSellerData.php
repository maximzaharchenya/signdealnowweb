<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealAdditionalSellerData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        return [
            'person' => ['required', 'boolean'],
            'role' => ['required', 'numeric'],
            'name' => ['required_if:person, ==, 0', 'string'],
            'surname' => ['required_if:person, ==, 0', 'string'],
            'commercial_name' => ['required_if:person, ==, 1', 'string'],
            'number' => ['required_if:person, ==, 0', 'string', 'max:20'],
            'date_of_birth' => ['required_if:person, ==, 0', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'regex:/^[+]+/', 'max:20'],
            'email' => ['required', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'family_status' => ['required_if:person, ==, 0', 'numeric'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
