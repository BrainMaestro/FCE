<?php
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;

/**
 * Created by BrainMaestro
 * Date: 27/3/2016
 * Time: 10:19 PM
 */
class SectionEventListenerTest extends TestCase
{
    protected $evaluationRepository;
    protected $keyRepository;
    protected $repository;
    protected $semesterRepository;
    protected $questionSetRepository;
    protected $listener;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(SectionRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->evaluationRepository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->semesterRepository = $this->getMockBuilder(SemesterRepository::class)->getMock();
        $this->questionSetRepository = $this->getMockBuilder(QuestionSetRepository::class)->getMock();

        $this->listener = new \Fce\Listeners\SectionEventListener(
            $this->repository,
            $this->evaluationRepository,
            $this->keyRepository,
            $this->semesterRepository,
            $this->questionSetRepository
        );
    }

    public function testOnSectionOpened()
    {
        $sectionId = $semesterId = $questionSetId = parent::ID;
        $section = $questionSet = [parent::ID];

        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with($sectionId)
            ->willReturn(['data' => $section]);

        $this->semesterRepository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => $semesterId]]);

        $this->semesterRepository->expects($this->once())
            ->method('getOpenQuestionSet')
            ->with($semesterId)
            ->willReturn(['id' => $questionSetId]);

        $this->questionSetRepository->expects($this->once())
            ->method('getQuestionSetById')
            ->with($questionSetId)
            ->willReturn(['data' => $questionSet]);

        $this->evaluationRepository->expects($this->once())
            ->method('createEvaluations')
            ->with($sectionId, $questionSet);

        $this->keyRepository->expects($this->once())
            ->method('createKeys')
            ->with($section);

        $this->listener->onSectionOpened($sectionId);
    }

    public function testOnSectionClosed()
    {
        $sectionId = parent::ID;

        $this->keyRepository->expects($this->once())
            ->method('deleteKeys')
            ->with($sectionId);

        $this->listener->onSectionClosed($sectionId);
    }
}
