<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'flat_number' => ['required', 'integer'],
            'floor_number' => ['required', 'integer'],
            'building_number' => ['required', 'integer'],
            'street_name' => ['required', 'string'],
            'area_id' => ['required', 'string'],
            'user' => ['required', 'integer'],
            'governorate' => ['required', 'integer']
        ];
    }
}
