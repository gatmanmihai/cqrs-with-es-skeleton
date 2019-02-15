<?php

namespace App\Domain\Contract\Repository;

use App\Domain\Exception\UserNotFoundException;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserId;
use Prooph\EventSourcing\AggregateChanged;

interface UserRepositoryInterface
{
    /**
     * @param UserId $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function get(UserId $id): User;

    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param AggregateChanged $event
     */
    public function addEvent(AggregateChanged $event): void;
}
