<?php

namespace App\Application\MessageHandler;

use App\Application\Command\CreateUserCommand;
use App\Domain\Contract\Security\Encoder\EncoderInterface;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserEmail;
use App\Domain\ValueObject\UserPassword;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateUserCommandHandler
{
    /**
     * @var EncoderInterface
     */
    protected $encoder;
    /**
     * @var MessageBusInterface
     */
    protected $eventBus;

    public function __construct(MessageBusInterface $eventBus, EncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateUserCommand $query)
    {
        $user = User::registerWithData(
            new UserEmail($query->getUsername()),
            UserPassword::fromPlainText($query->getPlainPassword(), $this->encoder)
        );

        foreach ($user->recordedEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
