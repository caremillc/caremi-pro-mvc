<?php 
namespace App\Providers;

use Careminate\Providers\ServiceProvider;
use Careminate\EventDispatcher\PostPersist;
use Careminate\EventDispatcher\ResponseEvent;
use Careminate\EventDispatcher\EventDispatcher;
use Careminate\EventListener\ContentLengthListener;
use Careminate\EventListener\InternalErrorListener;

class EventServiceProvider implements ServiceProvider
{
    private array $listen = [
        ResponseEvent::class => [
            //list of listeners
            InternalErrorListener::class,
            ContentLengthListener::class
        ],
        PostPersist::class => [
            //add eventlistener action
        ]
    ];

    public function __construct(private EventDispatcher $eventDispatcher)
    {
    }

    public function register(): void
    {
        // loop over each event in the listen array
        foreach ($this->listen as $eventName => $listeners) {
            // loop over each listener
            foreach (array_unique($listeners) as $listener) {
                // call eventDispatcher->addListener
                $this->eventDispatcher->addListener($eventName, new $listener());
            }
        }
    }
}

