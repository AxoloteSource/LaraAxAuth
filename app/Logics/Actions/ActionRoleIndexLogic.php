<?php

namespace App\Logics\Actions;

use App\Core\Data\IndexData;
use App\Core\Logics\IndexLogic;
use App\Http\Resources\Actions\RoleActionResource;
use App\Models\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\LaravelData\Data;

class ActionRoleIndexLogic extends IndexLogic
{
    public function __construct(protected Action $action)
    {
        parent::__construct($action);
    }

    public function makeQuery(): Builder
    {
        $query = $this->model->newQuery();
        $query->whereHas('roles');
        $query->with('roles', function ($query) {
            $query->where('roles.id', $this->input->id);
        });
        return $query;
    }

    public function run(IndexData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function withResource(): AnonymousResourceCollection
    {
        return RoleActionResource::collection($this->response);
    }
}
