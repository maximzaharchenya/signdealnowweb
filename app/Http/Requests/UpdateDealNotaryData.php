<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealNotaryData extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'surname' => ['nullable', 'string'],
            'name_surname_assistant' => ['nullable', 'string'],
            'service_activity_number' => ['nullable', 'numeric'],
            'year_of_service' => ['nullable', 'numeric'],
            'name_surname_assistant_judge' => ['nullable', 'string'],
            'notary_office' => ['nullable', 'string'],
            'region_notary_office' => ['nullable', 'string'],
            'city_notary_office' => ['nullable', 'string'],
            'address_notary_office' => ['nullable', 'string'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
