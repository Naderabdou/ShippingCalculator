<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\MasterApiRequest;

class ShippingCalculatorRequest extends MasterApiRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'monthly_shipments' => 'required|integer|in:250,500,501',
            'destination_type' => 'required|in:normal,remote',
            'weight' => 'required|numeric|max:20|min:0.1',
            'length' => 'required|numeric|min:0.1',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
        ];
    }
}
