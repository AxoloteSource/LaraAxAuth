<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getData(): array
    {
        return $this->validated();
    }
}
