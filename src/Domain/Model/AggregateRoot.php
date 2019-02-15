<?php

namespace App\Domain\Model;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot as BaseAggregateRoot;

abstract class AggregateRoot extends BaseAggregateRoot
{
    /**
     * @param \Iterator $events
     *
     * @return AggregateRoot
     */
    public static function fromEvents($events)
    {
        return self::reconstituteFromHistory($events);
    }

    /**
     * @return AggregateChanged[]
     */
    public function recordedEvents()
    {
        return $this->popRecordedEvents();
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (!\method_exists($this, $handler)) {
            throw new \RuntimeException(\sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                \get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . \implode(\array_slice(\explode('\\', \get_class($e)), -1));
    }
}