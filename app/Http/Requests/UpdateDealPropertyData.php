<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealPropertyData extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('inDeal', $this->deal_id);
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'numeric'],
            'area' => ['nullable', 'numeric'],
            'land_area' => ['nullable', 'numeric'],
            'used_land_area' => ['nullable', 'numeric'],
            'living_area' => ['nullable', 'numeric'],
            'purpose' => ['nullable', 'string'],
            'cadastral_number' => ['nullable', 'string'],
            'energy_class' => ['nullable', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'cadastral_number_property' => ['nullable', 'numeric'],
            'registration_number' => ['nullable', 'numeric'],
            'serf_number' => ['nullable', 'numeric'],
            'partnership_code' => ['nullable', 'numeric'],
            'owner_property' => ['nullable', 'string'],
            'personal_identification_code' => ['nullable', 'string'],
            'property_cost' => ['nullable', 'numeric'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
