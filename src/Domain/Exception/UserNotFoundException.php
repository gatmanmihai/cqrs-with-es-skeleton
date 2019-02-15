<?php

namespace App\Domain\Exception;

use App\Domain\ValueObject\UserId;

class UserNotFoundException extends DomainException
{
    /**
     * @param UserId $id
     *
     * @return UserNotFoundException
     */
    public static function byId(UserId $id)
    {
        return new self("User with id '{$id->__toString()}' not found");
    }
}
