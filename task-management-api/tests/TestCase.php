<?php

namespace Tests;

use Tests\Feature\Traits\LoginTrait;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LoginTrait;

    protected function setUp(): void {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->withoutExceptionHandling();
    }
}
