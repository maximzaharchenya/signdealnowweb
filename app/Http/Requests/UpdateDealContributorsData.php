<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateDealContributorsData extends FormRequest
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
            'name' => ['required_if:person, ==, 1', 'string'],
            'surname' => ['required_if:person, ==, 1', 'string'],
            'date_of_birth' => ['required_if:person, ==, 1', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'personal_number' => ['required_if:person, ==, 1', 'string'],
            'commercial_name' => ['required_if:person, ==, 0', 'string'],
            'commercial_code' => ['required_if:person, ==, 0', 'string'],
            'email' => ['required', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'regex:/^[+]+/', 'max:20'],
            'representative' => ['nullable', 'numeric'],
            'representative_name' => ['nullable', 'string'],
            'representative_surname' => ['nullable', 'string'],
            'representative_date_of_birth' => ['nullable', 'string', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'representative_email' => ['nullable', 'email', 'regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,6}/'],
            'representative_personal_number' => ['nullable', 'string', 'max:20'],
            'representative_phone' => ['nullable', 'regex:/^[+]+/', 'max:20'],
            'representative_file' => ['nullable', 'mimes:pdf'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST)
        );
    }


}
