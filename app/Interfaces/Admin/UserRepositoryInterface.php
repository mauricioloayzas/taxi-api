<?php

namespace App\Interfaces\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getAllUsers(array $meta):LengthAwarePaginator;

    public function getUser(int $userId):Model;
    public function createUser(array $userArray): Model;
    public function updateUser(int $userId, array $userArray): void;
    public function changeUserStatus(int $userId, string $status): void;
    public function removeUser(int $userId): void;

}
