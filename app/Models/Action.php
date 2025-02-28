<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public static function withRolesCheck(array $actionNames, int $roleId): Collection
    {
        return Action::whereIn('name', $actionNames)
            ->with(['roles' => function ($query) use ($roleId) {
                $query->where('roles.id', $roleId);
            }])
            ->get();
    }
}
