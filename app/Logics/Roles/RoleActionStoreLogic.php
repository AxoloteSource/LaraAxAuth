<?php

namespace App\Logics\Roles;

use App\Core\Enums\Http;
use App\Core\Logics\Logic;
use App\Core\Traits\OnlyWithAction;
use App\Data\Role\StoreRoleActionData;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

class RoleActionStoreLogic extends Logic
{
    use OnlyWithAction;

    protected Data|StoreRoleActionData $input;

    public function run(StoreRoleActionData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function action(): Logic
    {
        $this->input->roles->each(function ($actions, $roleKey) {
            $role = Role::firstOrCreate(
                ['key' => strtolower($roleKey)],
                ['name' => ucfirst($roleKey)]
            );

            $actionIds = collect($actions)->map(function ($actionName) {
                return Action::firstOrCreate(['name' => $actionName])->id;
            });

            $role->actions()->sync($actionIds);
        });

        return $this;
    }

    protected function response(): JsonResponse
    {
        return Response::success(data: $this->withResource(), status: Http::Created);
    }
}
