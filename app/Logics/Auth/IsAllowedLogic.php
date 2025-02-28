<?php

namespace App\Logics\Auth;

use App\Core\Logics\Logic;
use App\Core\Traits\OnlyWithAction;
use App\Data\Auth\IsAllowedData;
use App\Models\Action;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class IsAllowedLogic extends Logic
{
    use OnlyWithAction;

    protected Data|IsAllowedData $input;

    public function run(IsAllowedData $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function action(): Logic
    {
        $this->response = $this->checkRoles();

        return $this;
    }

    private function checkRoles(): array
    {
        $actionsWithRoles = Action::withRolesCheck($this->input->actions, $this->user()->role->id)
            ->mapWithKeys(fn ($action) => [$action->name => $action->roles->isNotEmpty()])
            ->toArray();

        return array_replace(array_fill_keys($this->input->actions, false), $actionsWithRoles);
    }
}
