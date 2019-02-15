<?php

namespace App\Domain\Exception;

class InvalidUserIdException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Given id ({$id}) is not a valid user id.");
    }
}