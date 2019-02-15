<?php

namespace App\Infrastructure\Projector;

use App\Domain\Contract\Storage\UserStorageInterface;
use App\Domain\Event\UserWasRegistered;
use App\Infrastructure\ReadModel\User;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class UserProjector implements MessageSubscriberInterface
{
    /**
     * @var UserStorageInterface
     */
    protected $userStorage;

    public function __construct(UserStorageInterface $userStorage)
    {
        $this->userStorage = $userStorage;
    }

    public static function getHandledMessages(): iterable
    {
        return [
            UserWasRegistered::class => 'storeUser',
        ];
    }

    public function storeUser(UserWasRegistered $event)
    {
        $readUser = new User();
        $readUser->setId($event->userId())
            ->setUsername($event->email())
            ->setPassword($event->password());

        $this->userStorage->save($readUser);
    }
}
