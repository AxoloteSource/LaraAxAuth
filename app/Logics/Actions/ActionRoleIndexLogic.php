<?php

namespace App\Logics\Actions;

use App\Core\Data\IndexData;
use App\Core\Logics\IndexLogic;
use App\Http\Resources\Actions\RoleActionResource;
use App\Models\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\LaravelData\Data;

class ActionRoleIndexLogic extends IndexLogic
{
    public function __construct(protected Action $action)
    {
        parent::__construct($action);
    }

    public function run(IndexData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function withResource(): AnonymousResourceCollection
    {
        $asignedActions = Action::whereHas('roles', function ($query) {
            $query->where('roles.id', $this->input->id);
        })->pluck('id');
        $response = $this->response->map(function ($action) use ($asignedActions) {
            $action->active = $asignedActions->contains($action->id);
            return $action;
        });
        return RoleActionResource::collection($response);
    }
}
