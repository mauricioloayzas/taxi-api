<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\UserRepositoryInterface;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Mosquitto\Client;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $meta
     * @return LengthAwarePaginator
     */
    public function getAllUsers(array $meta): LengthAwarePaginator
    {
        $collection = User::paginate();

        if(count($meta) > 0){
            $collection = (isset($meta['status'])) ?
                User::where('status', '=', $meta['status'])->paginate() :
                $collection;
        }
        return $collection;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function getUser(int $userId): User
    {
        $user = User::findOrFail($userId);
        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        $user = User::where('email', $email)->firstOrFail();
        return $user;
    }

    /**
     * @param array $userArray
     * @return User
     */
    public function createUser(array $userArray): User
    {
        return User::create($userArray);
    }

    /**
     * @param $userId
     * @param array $userArray
     * @return void
     */
    public function updateUser($userId, array $userArray): void
    {
        User::whereId($userId)->update($userArray);
    }

    /**
     * @param int $userId
     * @param string $status
     * @return void
     */
    public function changeUserStatus(int $userId, string $status): void
    {
        User::whereId($userId)->update(['status' => $status]);
    }

    /**
     * @param $userId
     * @return void
     */
    public function removeUser($userId): void
    {
        User::destroy($userId);
    }
}
