<?php

namespace App\Application\Middleware;

use App\Domain\Contract\Event\DomainEventInterface;
use App\Domain\Contract\Repository\UserRepositoryInterface;
use Prooph\EventSourcing\AggregateChanged;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AggregateEventStoreMiddleware implements MiddlewareInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $eventBasedUserRepository;

    public function __construct(UserRepositoryInterface $eventBasedUserRepository)
    {
        $this->eventBasedUserRepository = $eventBasedUserRepository;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if ($envelope->getMessage() instanceof DomainEventInterface) {
            /** @var AggregateChanged $event */
            $event = $envelope->getMessage();
            $this->eventBasedUserRepository->addEvent($event);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
