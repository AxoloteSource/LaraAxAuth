<?php

namespace App\Kernel\Request;

use App\Kernel\KernelLogic;
use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request
{
    use KernelLogic;

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
