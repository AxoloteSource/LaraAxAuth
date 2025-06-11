<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('value');
            $table->uuid('setting_value_type_id')
                ->default('30C19D20-466D-11F0-AD55-51073ABD5648');
            $table->foreign('setting_value_type_id')
                ->references('id')->on('setting_value_types')
                ->restrictOnDelete();
            $table->boolean('encrypted')->default(false);
            $table->boolean('is_public')->default(false);
            $table->string('group')->default('app');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
