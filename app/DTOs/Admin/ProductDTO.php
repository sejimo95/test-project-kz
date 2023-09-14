<?php

namespace App\DTOs\Admin;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ProductDTO extends ValidatedDTO
{
    /**
     * Defines the validation rules for the DTO.
     */
    protected function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:100'],
            'price'          => ['required', 'int', 'max:20'],
            'description'    => ['required', 'string', 'max:5000'],
            'available'      => ['nullable', 'in:0,1'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
        ];
    }

    /**
     * Defines the default values for the properties of the DTO.
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Defines the type casting for the properties of the DTO.
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Maps the DTO properties before the DTO instantiation.
     */
    protected function mapBeforeValidation(): array
    {
        return [];
    }

    /**
     * Maps the DTO properties before the DTO export.
     */
    protected function mapBeforeExport(): array
    {
        return [];
    }

    /**
     * Defines the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Defines the custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [];
    }
}
