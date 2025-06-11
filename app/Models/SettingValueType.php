<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SettingValueType extends Model
{
    use HasFactory;

    protected $keyType = 'uuid';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }
}
