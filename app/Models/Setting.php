<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'value',
        'setting_value_type_id',
        'encrypted',
        'is_public',
        'group',
    ];

    protected $casts = [
        'encrypted' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function settingValueType(): BelongsTo
    {
        return $this->belongsTo(SettingValueType::class);
    }
}
