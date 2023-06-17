<?php

namespace Tests\Feature;

use App\Enums\ApiStatuses;
use App\Models\Admin\User;
use Illuminate\Http\Response;

class UserControllerTest extends \Tests\TestCase
{
    /** @var User */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_should_get_all_users_correctly()
    {
        $response = $this->getJson('api/users')->assertStatus(Response::HTTP_OK)->json('data');
        $this->assertEquals('Mrs. Cleta Kemmer Sr.', $response[0]['name']);
    }

    public function test_should_get_a_single_user_correctly()
    {
        $response = $this->getJson('api/users/1')->assertStatus(Response::HTTP_OK)->json();

        $this->assertEquals('Mrs. Cleta Kemmer Sr.', $response['name']);
    }

    public function test_should_get_404_error_if_user_does_not_exists()
    {
        $response = $this->getJson('api/users/999999')->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('The user does not exists.', $response['message']);
    }

    public function test_should_create_a_new_user()
    {
        $user = User::factory()->make();
        $response = $this->postJson('api/users', [
            'name'      => $user->name,
            'email'     => $user->email,
            'password'  => $user->password,
            'status'    => ApiStatuses::ACTIVE
        ])->assertStatus(Response::HTTP_CREATED)->json();

        $this->assertEquals($user->name, $response['name']);
    }

    public function test_should_update_a_user_correctly()
    {
        $response = $this->putJson('api/users/20', ['name' => 'updated name'])
            ->assertStatus(Response::HTTP_OK)->json();
        $this->assertEquals('updated name', $response['name']);
    }

    public function test_should_update_with_404_error_if_user_does_not_exists()
    {
        $response = $this->putJson('api/users/999999', ['name' => 'updated name'])
            ->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('The user does not exists.', $response['message']);
    }

    public function test_should_change_a_user_status_correctly()
    {
        $response = $this->putJson('api/users/20/status/Inactive', [])
            ->assertStatus(Response::HTTP_OK)->json();
        $this->assertEquals('Inactive', $response['status']);
    }

    public function test_should_delete_a_user_correctly()
    {
        $this->deleteJson('api/users/22')->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_should_delete_with_404_error_if_user_does_not_exists()
    {
        $response = $this->deleteJson('api/users/999999')->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('The user does not exists.', $response['message']);
    }
}
