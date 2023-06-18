<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;
use App\Models\Admin\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserService
{
    /**
     *
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     *
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all battles.
     *
     * @param array $meta
     * @return LengthAwarePaginator
     *
     */
    public function getAll(array $meta): LengthAwarePaginator
    {
        return $this->userRepository->getAllUsers($meta);
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User
    {
        return  $this->userRepository->getUser($id);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        return  $this->userRepository->getUserByEmail($email);
    }

    /**
     * Create a user.
     *
     * @param mixed $newUser
     *
     * @return User|JsonResponse
     *
     */
    public function createUser($newUser): User|JsonResponse
    {
        return $this->userRepository->createUser($newUser);
    }

    /**
     * Update a user.
     *
     * @param mixed $userId
     * @param mixed $newUser
     *
     * @return User
     *
     */
    public function updateUser($userId, $newUser): User
    {
        $this->userRepository->updateUser($userId, $newUser);
        return  $this->userRepository->getUser($userId);
    }

    /**
     * @param int $userId
     * @param string $status
     * @return User
     */
    public function changeUserStatus(int $userId, string $status): User
    {
        $this->userRepository->changeUserStatus($userId, $status);
        return  $this->userRepository->getUser($userId);
    }

    /**
     * Change a user status.
     *
     * @param mixed $userId
     *
     * @return void
     *
     */
    public function removeUser($userId): void
    {
        $this->userRepository->removeUser($userId);
    }
}
