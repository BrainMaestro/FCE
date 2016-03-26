<?php
/**
 * Created by BrainMaestro
 * Date: 26/3/2016
 * Time: 6:24 PM
 */

namespace Fce\Listeners;

use Fce\Events\Event;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Support\Facades\Input;

class SectionEventListener
{
    /**
     * @var EvaluationRepository
     */
    private $evaluationRepository;
    /**
     * @var KeyRepository
     */
    private $keyRepository;
    /**
     * @var SectionRepository
     */
    private $repository;
    /**
     * @var SemesterRepository
     */
    private $semesterRepository;
    /**
     * @var QuestionSetRepository
     */
    private $questionSetRepository;

    /**
     * SectionEventListener constructor.
     *
     * @param SectionRepository $repository
     * @param EvaluationRepository $evaluationRepository
     * @param KeyRepository $keyRepository
     * @param SemesterRepository $semesterRepository
     * @param QuestionSetRepository $questionSetRepository
     */
    public function __construct(
        SectionRepository $repository,
        EvaluationRepository $evaluationRepository,
        KeyRepository $keyRepository,
        SemesterRepository $semesterRepository,
        QuestionSetRepository $questionSetRepository
    ) {
        $this->repository = $repository;
        $this->evaluationRepository = $evaluationRepository;
        $this->keyRepository = $keyRepository;
        $this->semesterRepository = $semesterRepository;
        $this->questionSetRepository = $questionSetRepository;
    }

    /**
     * Handle section opened events.
     * 
     * @param $sectionId
     */
    public function onSectionOpened($sectionId)
    {
        $section = $this->repository->getSectionById($sectionId)['data'];
        $semesterId = $this->semesterRepository->getCurrentSemester()['data']['id'];
        $questionSetId = $this->semesterRepository->getOpenQuestionSet($semesterId)['id'];
        $questionSet = $this->questionSetRepository->getQuestionSetById($questionSetId)['data'];
        
        // Create the section's evaluations.
        $this->evaluationRepository->createEvaluations($sectionId, $questionSet);
        
        // Create the section's keys.
        $this->keyRepository->createKeys($section);
    }

    /**
     * Handle section closed events.
     * 
     * @param $sectionId
     */
    public function onSectionClosed($sectionId)
    {
        $this->keyRepository->deleteKeys($sectionId);
    }
    
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            Event::SECTION_OPENED,
            'Fce\Listeners\SectionEventListener@onSectionOpened'
        );

        $events->listen(
            Event::SECTION_CLOSED,
            'Fce\Listeners\SectionEventListener@onSectionClosed'
        );
    }
}