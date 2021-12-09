<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealMortgageData extends FormRequest
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
            'energy_class' => ['nullable', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'cadastral_number' => ['nullable', 'string'],
            'registration_number' => ['nullable', 'numeric'],
            'land_register_number' => ['nullable', 'numeric'],
            'serf_number' => ['nullable', 'numeric'],
            'partnership_code' => ['nullable', 'numeric'],
            'owner' => ['nullable', 'string'],
            'owner_code' => ['nullable', 'string'],
            'cost' => ['nullable', 'numeric'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
