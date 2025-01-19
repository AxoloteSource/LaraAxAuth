<?php

namespace Tests;

use App\Kernel\ErrorContainer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
        ErrorContainer::resetErrors();
        $this->withoutExceptionHandling();
    }

}
