<?php

namespace App\Domain\Model;

use App\Domain\Contract\Security\Encoder\EncoderInterface;
use App\Domain\Event\UserWasRegistered;
use App\Domain\ValueObject\UserEmail;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\UserPassword;

class User extends AggregateRoot
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param UserEmail        $email
     * @param string           $plainPassword
     * @param EncoderInterface $encoder
     *
     * @return User
     * @throws \Exception
     */
    public static function registerWithData(UserEmail $email, UserPassword $password): User
    {
        $self = new self();
        $self->recordThat(UserWasRegistered::withData(
            UserId::create(), $email, $password
        ));

        return $self;
    }

    /**
     * @param UserWasRegistered $event
     */
    protected function whenUserWasRegistered(UserWasRegistered $event): void
    {
        $this->id = $event->userId();
        $this->email = $event->email();
        $this->password = $event->password();
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }
}
