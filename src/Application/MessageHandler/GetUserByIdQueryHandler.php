<?php

namespace App\Application\MessageHandler;

use App\Application\Query\GetUserByIdQuery;
use App\Domain\Contract\Storage\UserStorageInterface;

class GetUserByIdQueryHandler
{
    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    public function __construct(UserStorageInterface $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    public function __invoke(GetUserByIdQuery $query)
    {
        return $this->userStorage->get($query->getId());
    }
}
