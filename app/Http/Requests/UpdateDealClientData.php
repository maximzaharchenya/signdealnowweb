<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealClientData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        if ($this->local_bank)
            return [
                'local_bank' => ['required', 'boolean'],
                'bank_name' => ['required', 'string', 'max:191'],
                'bank_number' => ['required', 'string'],
                'branch_code' => ['required', 'string'],
                'client_account_number' => ['required', 'string'],
                'bank_address' => ['required', 'string'],
                'bank_email' => ['nullable', 'string'],
                'mortgage_amount' => ['nullable', 'numeric'],
                'days_to_conclude_insurance_after_signing' => ['nullable', 'numeric'],
                'insurance_penalty' => ['nullable', 'numeric'],
                'bank_representative_name' => ['nullable', 'string'],
                'bank_representative_surname' => ['nullable', 'string'],
                'the_pledge_holder_of_all_objects_is_one_bank' => ['required', 'boolean'],
                'bank_representative_personal_code' => ['nullable', 'string'],
                'mortgage_holder_name' => ['nullable', 'string'],
                'mortgage_holder_number' => ['nullable', 'string'],
                'mortgage_holder_code' => ['nullable', 'string'],
                'mortgage_holder_email' => ['nullable', 'string'],
                'mortgage_holder_address' => ['nullable', 'string'],
                'additional_collateral_cost' => ['nullable', 'string'],
                'mortgage_holder_representative_name' => ['nullable', 'string'],
                'mortgage_holder_representative_surname' => ['nullable', 'string'],
                'mortgage_holder_representative_code' => ['nullable', 'string'],
            ];
        else
            return [
                'local_bank' => ['required', 'boolean'],
                'bank_name' => ['required', 'string', 'max:191'],
                'bank_number' => ['required', 'string'],
                'branch_code' => ['required', 'string'],
                'client_account_number' => ['required', 'string'],
                'bank_address' => ['required', 'string'],
                'bank_email' => ['nullable', 'string'],
                'mortgage_amount' => ['nullable', 'numeric'],
                'days_to_conclude_insurance_after_signing' => ['nullable', 'numeric'],
                'insurance_penalty' => ['nullable', 'numeric'],
                'foreign_bank_name' => ['nullable', 'string'],
                'foreign_bank_number' => ['nullable', 'string'],
                'foreign_bank_code' => ['nullable', 'string'],
                'foreign_bank_address' => ['nullable', 'string'],
                'foreign_bank_email' => ['nullable', 'string'],
                'bank_representative_name' => ['nullable', 'string'],
                'bank_representative_surname' => ['nullable', 'string'],
                'bank_representative_personal_code' => ['nullable', 'string'],
                'mortgage_holder_name' => ['nullable', 'string'],
                'mortgage_holder_number' => ['nullable', 'string'],
                'mortgage_holder_code' => ['nullable', 'string'],
                'mortgage_holder_email' => ['nullable', 'string'],
                'mortgage_holder_address' => ['nullable', 'string'],
                'additional_collateral_cost' => ['nullable', 'string'],
                'mortgage_holder_representative_name' => ['nullable', 'string'],
                'mortgage_holder_representative_surname' => ['nullable', 'string'],
                'mortgage_holder_representative_code' => ['nullable', 'string'],
                'the_pledge_holder_of_all_objects_is_one_bank' => ['nullable', 'string'],
                'mortgage_holder_representative_bank_name' => ['nullable', 'string'],
                'mortgage_holder_representative_bank_number' => ['nullable', 'string'],
                'mortgage_holder_representative_bank_email' => ['nullable', 'string'],
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
