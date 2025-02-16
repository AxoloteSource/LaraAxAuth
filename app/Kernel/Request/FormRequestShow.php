<?php

namespace App\Kernel\Request;

use Illuminate\Support\Str;

abstract class FormRequestShow extends FormRequest
{
    abstract public function name();

    public function rules(): array
    {
        $name = Str::snake($this->name());

        return [
            'id' => "required|exists:{$name},id",
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
