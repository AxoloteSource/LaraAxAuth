<?php

namespace App\Core\Request;

use App\Core\CoreLogic;
use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request
{
    use CoreLogic;

    protected array $rules = [];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->rules;
    }
}
