<?php

use Fce\Listeners\EvaluationSubmitted;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\CommentRepository;

/**
 * Created by BrainMaestro
 * Date: 13/3/2016
 * Time: 2:25 AM.
 */
class EvaluationSubmittedTest extends TestCase
{
    protected $repository;
    protected $commentRepository;
    protected $listener;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->commentRepository = $this->getMockBuilder(CommentRepository::class)->getMock();

        $this->listener = new EvaluationSubmitted($this->repository, $this->commentRepository);
    }

    public function testIncrementEvaluation()
    {
        $evaluations = [
            ['id' => parent::ID, 'column' => parent::ID],
            ['id' => parent::ID, 'column' => parent::ID],
            ['id' => parent::ID, 'column' => parent::ID],
        ];
        $comment = factory(Fce\Models\Comment::class)->make()->comment;
        $sectionId = parent::ID;
        $questionSetId = parent::ID;

        $this->repository->expects($this->exactly(3))
            ->method('incrementEvaluation')->with(parent::ID, parent::ID);

        $this->commentRepository->expects($this->once())
            ->method('createComment')->with($sectionId, $questionSetId, $comment);

        $this->listener->handle($evaluations, $comment, $sectionId, $questionSetId);
    }
}
