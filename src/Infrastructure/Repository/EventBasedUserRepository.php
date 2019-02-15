<?php

namespace App\Infrastructure\Repository;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Model\User;
use App\Domain\ValueObject\UserId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\AggregateChanged;

class EventBasedUserRepository extends AggregateRepository implements UserRepositoryInterface
{
    public function addEvent(AggregateChanged $event): void
    {
        $streamName = $this->determineStreamName($event->aggregateId());
        $event = $this->enrichEventMetadata($event, $event->aggregateId());

        $this->eventStore->appendTo($streamName, new \ArrayIterator([$event]));
    }

    /**
     * @inheritdoc
     */
    public function save(User $user): void
    {
        $this->saveAggregateRoot($user);
    }

    /**
     * @inheritdoc
     */
    public function get(UserId $userId): User
    {
        /** @var User $user */
        $user = $this->getAggregateRoot($userId->__toString());

        return $user;
    }
}
