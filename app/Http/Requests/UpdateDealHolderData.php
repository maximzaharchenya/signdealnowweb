<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealHolderData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        return [
            'mortgage_holder_local_bank' => ['required', 'string'],
            'mortgage_holder_name' => ['required', 'string'],
            'mortgage_holder_number' => ['required', 'string'],
            'mortgage_holder_address' => ['required', 'string'],
            'mortgage_holder_code' => ['nullable', 'numeric'],
            'mortgage_holder_email' => ['nullable','email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'additional_collateral_cost' => ['nullable', 'numeric'],

            'mortgage_holder_representative_name' => ['nullable', 'string'],
            'mortgage_holder_representative_surname' => ['nullable', 'string'],
            'mortgage_holder_representative_code' => ['nullable', 'string'],
            'mortgage_holder_representative_bank_name' => ['nullable', 'string'],
            'mortgage_holder_representative_bank_number' => ['nullable', 'string'],
            'mortgage_holder_representative_bank_email' => ['nullable', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'mortgage_holder_representative_bank_address' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
