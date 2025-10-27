<?php

namespace App\Logics\Actions;

use App\Core\Logics\UpdateLogic;
use App\Data\ActionRole\UpdateActionRoleData;
use App\Models\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class ActionRoleUpdateLogic extends UpdateLogic
{
    public Action|Model $model;
    public function __construct(Action $action)
    {
        parent::__construct($action);
    }

    public function run(UpdateActionRoleData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function before(): bool
    {
        $id = $this->input->id;
        $action = $this->model->find($this->input->action_id);
        $this->input->active ? $action->roles()->syncWithoutDetaching([$id]) : $action->roles()->detach($id);
        return true;
    }
}
