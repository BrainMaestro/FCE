<?php
use Fce\Listeners\EvaluationSubmitted;
use Fce\Repositories\Contracts\EvaluationRepository;

/**
 * Created by BrainMaestro
 * Date: 13/3/2016
 * Time: 2:25 AM
 */
class EvaluationSubmittedTest extends TestCase
{
    protected $repository;
    protected $listener;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(EvaluationRepository::class)->getMock();

        $this->listener = new EvaluationSubmitted($this->repository);
    }

    public function testIncrementEvaluation()
    {
        $evaluations = [
            ['id' => parent::ID, 'column' => parent::ID],
            ['id' => parent::ID, 'column' => parent::ID],
            ['id' => parent::ID, 'column' => parent::ID]
        ];
        
        $this->repository->expects($this->exactly(3))
            ->method('incrementEvaluation')->with(parent::ID, parent::ID);

        $this->listener->handle(...$evaluations);
    }
}
