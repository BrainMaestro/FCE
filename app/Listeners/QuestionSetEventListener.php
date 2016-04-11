<?php

namespace Fce\Listeners;

use Fce\Events\Event;
use Fce\Repositories\Contracts\UserRepository;
use Fce\Utility\Status;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Repositories\Contracts\HelperRepository;
use Illuminate\Support\Facades\Input;

class QuestionSetEventListener
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * Create the event listener.
     * @param UserRepository $userRepository
     * @param SectionRepository $sectionRepository
     */
    public function __construct(UserRepository $userRepository, SectionRepository $sectionRepository) {
        $this->userRepository = $userRepository;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * Handle question set open events.
     *
     * @param $semesterId
     */
    public function onQuestionSetOpened($semesterId)
    {
        // Get only the id and course_code
        Input::merge(['columns' => 'id,course_code']);
        $sections = $this->sectionRepository->getSectionsBySemester($semesterId, true);

        $this->userRepository->createHelperUsers($sections['data']);
    }

    /**
     * Handle question set close events.
     */
    public function onQuestionSetClosed()
    {
        $this->userRepository->deleteHelperUsers();
    }
    
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            Event::QUESTION_SET_OPENED,
            'Fce\Listeners\QuestionSetEventListener@onQuestionSetOpened'
        );

        $events->listen(
            Event::QUESTION_SET_CLOSED,
            'Fce\Listeners\QuestionSetEventListener@onQuestionSetClosed'
        );
    }
}
