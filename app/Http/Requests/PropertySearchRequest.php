<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertySearchRequest extends FormRequest
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
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bedrooms' => ['sometimes', 'nullable', 'integer'],
            'bathrooms' => ['sometimes', 'nullable', 'integer'],
            'storeys' => ['sometimes', 'nullable', 'integer'],
            'garages' => ['sometimes', 'nullable', 'integer'],
            'price' => ['sometimes', 'nullable', 'array', 'size:2'],
            'price.*' => ['integer'],
        ];
    }

    protected function passedValidation(): void
    {
        $price = $this->validated('price');
        $bedrooms = $this->validated('bedrooms');
        $bathrooms = $this->validated('bathrooms');
        $storeys = $this->validated('storeys');
        $garages = $this->validated('garages');

        $normalized = [
            'price' => is_array($price) ? array_map(fn ($val) => (int) $val, $price) : null,
            'bedrooms' => isset($bedrooms) ? (int) $bedrooms : null,
            'bathrooms' => isset($bathrooms) ? (int) $bathrooms : null,
            'storeys' => isset($storeys) ? (int) $storeys : null,
            'garages' => isset($garages) ? (int) $garages : null,
        ];

        $merge = [];

        foreach ($normalized as $key => $value) {
            if ($this->has($key)) {
                $merge[$key] = $value;
            }
        }

        $this->merge($merge);
    }
}
