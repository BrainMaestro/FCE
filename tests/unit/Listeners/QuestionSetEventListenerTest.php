<?php

use Fce\Listeners\QuestionSetEventListener;
use Fce\Repositories\Contracts\UserRepository;
use Fce\Repositories\Contracts\SectionRepository;

class QuestionSetEventListenerTest extends TestCase
{
    protected $sectionRepository;
    protected $userRepository;
    protected $listener;

    public function setUp()
    {
        parent::setUp();
        $this->sectionRepository = $this->getMockBuilder(SectionRepository::class)->getMock();
        $this->userRepository = $this->getMockBuilder(UserRepository::class)->getMock();

        $this->listener = new QuestionSetEventListener($this->userRepository, $this->sectionRepository);
    }

    public function testOnQuestionSetOpened()
    {
        $this->sectionRepository->expects($this->once())
            ->method('getSectionsBySemester')->willReturn(['data' => []]);

        $this->userRepository->expects($this->once())
            ->method('createHelperUsers')->with([]);

        $this->listener->onQuestionSetOpened(parent::ID);
    }

    public function testOnQuestionSetClosed()
    {
        $this->userRepository->expects($this->once())
            ->method('deleteHelperUsers')->with();

        $this->listener->onQuestionSetClosed();
    }
}
