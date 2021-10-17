<?php

namespace Shopapp\Services\EventsService;

class EventsService
{
    /**
     * @var array $events
     */
    private array $events = [];

    /**
     * @param string $eventName
     * @param $listenerClass
     */
    public function registerListener(string $eventName, $listenerClass)
    {
        if (isset($this->events[$eventName])) {
            $this->events[$eventName][] = $listenerClass;
        } else {
            $this->events[$eventName] = [$listenerClass];
        }
    }

    /**
     * @param string $eventName
     * @param array $params
     */
    public function fireEvent(string $eventName, array $params): void
    {
        foreach ($this->events[$eventName] as $eventClass) {
            $instance = new $eventClass;
            $instance->handle(...$params);
        }
    }
}