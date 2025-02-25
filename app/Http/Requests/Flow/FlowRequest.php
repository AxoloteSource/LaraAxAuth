<?php

namespace App\Http\Requests\Flow;

use App\Http\Requests\FormRequest;

class FlowRequest extends FormRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->rules,
            [
                'model' => 'required|string',
                'with_desactives' => 'nullable|boolean',
            ]
        );
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'model' => $this->route('model'),
        ]);
    }
}
