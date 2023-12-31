<?php

namespace Tests;

use App\Models\Admin\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * To can create an user
     *
     * @param $args
     * @return User
     */
    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }
}
