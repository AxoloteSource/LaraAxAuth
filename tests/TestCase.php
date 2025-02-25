<?php

namespace Tests;

use App\Core\ErrorContainer;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions, WithFaker;

    public static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();
        if (! self::$migrated) {
            self::refreshDatabase();
            self::$migrated = true;
        }
        ErrorContainer::resetErrors();
        Mail::fake();
        $this->withoutExceptionHandling();
    }

    public function refreshDatabase(): void
    {
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function loginRoot(): User
    {
        $user = User::factory()->create(['role_id' => RoleEnum::Root->value]);
        Sanctum::actingAs($user, ['*']);

        return $user;
    }
}
