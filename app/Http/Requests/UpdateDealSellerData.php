<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealSellerData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        return [
            'local_bank' => ['required', 'boolean'],
            'bank_name' => ['required', 'string', 'max:191'],
            'bank_number' => ['required', 'string'],
            'seller_account_number' => ['required', 'string'],
            'bank_address' => ['required', 'string'],
            'bank_email' => ['nullable', 'string'],
            'bank_representative_name' => ['nullable', 'string'],
            'bank_representative_surname' => ['nullable', 'string'],
            'bank_representative_personal_code' => ['nullable', 'string'],
            'is_pledged' => ['required', 'boolean'],
            'investment_return' => ['nullable', 'numeric'],
            'mortgage_holder_name' => ['nullable', 'string'],
            'mortgage_holder_code' => ['nullable', 'string'],
            'mortgage_holder_address' => ['nullable', 'string'],
            'mortgage_holder_representative_name' => ['nullable', 'string'],
            'mortgage_holder_representative_surname' => ['nullable', 'string'],
            'mortgage_holder_representative_code' => ['nullable', 'string'],
            'filial_bank_name' => ['nullable', 'string'],
            'filial_bank_number' => ['nullable', 'string'],
            'filial_bank_code' => ['nullable', 'string'],
            'filial_bank_email' => ['nullable', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'filial_bank_address' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
