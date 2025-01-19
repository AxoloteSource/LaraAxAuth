<?php

namespace App\Kernel\Request;

class FormRequestPaginate extends FormRequest
{
    protected array $rules = [
        'page' => 'sometimes|integer|min:1',
        'limit' => 'sometimes|integer|min:1',
        'filters' => 'sometimes|array',
        'search' => 'nullable|string',
    ];
}
