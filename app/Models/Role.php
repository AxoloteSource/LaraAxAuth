<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['name', 'description'];

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}