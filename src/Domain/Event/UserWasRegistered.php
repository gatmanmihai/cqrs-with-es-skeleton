<?php

namespace App\Domain\Event;

use App\Domain\Contract\Event\DomainEventInterface;
use App\Domain\ValueObject\UserEmail;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserPassword;
use Prooph\EventSourcing\AggregateChanged;

final class UserWasRegistered extends AggregateChanged implements DomainEventInterface
{
    public static function withData(UserId $userId, UserEmail $email, UserPassword $password): UserWasRegistered
    {
        /** @var self $event */
        $event = self::occur($userId->__toString(), [
            'email'    => $email->getAddress(),
            'password' => $password->__toString(),
        ]);

        return $event;
    }

    public function userId(): string
    {
        return $this->aggregateId();
    }

    public function password(): string
    {
        return $this->payload['password'];
    }

    public function email(): string
    {
        return $this->payload['email'];
    }
}
