<?php

namespace App\Domain\Contract\Storage;

use App\Domain\Exception\UserNotFoundException;
use App\Infrastructure\ReadModel\User;

interface UserStorageInterface
{
    /**
     * @param mixed $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function get($id): User;

    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param mixed $id
     *
     * @return User|null
     */
    public function findById($id): ?User;

    /**
     * @return User[]
     */
    public function findAll();
}