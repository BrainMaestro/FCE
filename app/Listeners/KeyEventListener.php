<?php
/**
 * Created by BrainMaestro
 * Date: 12/3/2016
 * Time: 7:02 PM.
 */
namespace Fce\Listeners;

use Fce\Events\Event;
use Fce\Repositories\Contracts\KeyRepository;

class KeyEventListener
{
    /**
     * @var KeyRepository
     */
    protected $repository;

    public function __construct(KeyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle key given out events.
     */
    public function onKeyGivenOut($value)
    {
        return $this->repository->setGivenOut($value);
    }

    /**
     * Handle key used events.
     */
    public function onKeyUsed($value)
    {
        return $this->repository->setUsed($value);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            Event::KEY_GIVEN_OUT,
            'Fce\Listeners\KeyEventListener@onKeyGivenOut'
        );

        $events->listen(
            Event::KEY_USED,
            'Fce\Listeners\KeyEventListener@onKeyUsed'
        );
    }
}
