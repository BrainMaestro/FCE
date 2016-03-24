<?php
use Fce\Http\Controllers\EvaluationController;
use Fce\Http\Requests\EvaluationRequest;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;

/**
 * Created by BrainMaestro
 * Date: 12/3/2016
 * Time: 7:15 PM
 */
class EvaluationControllerTest extends TestCase
{
    protected $request;
    protected $repository;
    protected $keyRepository;
    protected $semesterRepository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->request = new EvaluationRequest;
        $this->repository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->semesterRepository = $this->getMockBuilder(SemesterRepository::class)->getMock();

        $this->controller = new EvaluationController($this->repository, $this->keyRepository, $this->semesterRepository);
    }

    public function testIndex()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'value' => parent::KEY,
                    'section_id' => parent::ID,
                    'given_out' => false,
                ]
            ]);

        $this->semesterRepository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => parent::ID]]);

        $this->semesterRepository->expects($this->once())
            ->method('getOpenQuestionSet')->with(parent::ID)
            ->willReturn(['id' => parent::ID]);

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::KEY_GIVEN_OUT, parent::KEY, false);

        $this->repository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')
            ->with(parent::ID, parent::ID);

        $this->controller->index(parent::KEY);
    }

    public function testIndexWithGivenOutKey()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'given_out' => true,
                ]
            ]);

        $this->assertEquals(
            $this->controller->respondForbidden('This key has already been given out'),
            $this->controller->index(parent::KEY)
        );
    }

    public function testIndexException()
    {
        // 404 - Not found
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Key does not exist'),
            $this->controller->index(parent::KEY)
        );

        // 500 - Internal server error
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list the evaluations'),
            $this->controller->index(parent::KEY)
        );
    }

    public function testSubmitEvaluations()
    {
        $this->request->merge([
            'semester_id' => parent::ID,
            'question_set_id' => parent::ID,
            'evaluations' => [parent::ID],
            'comment' => 'comment',
        ]);

        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'value' => parent::KEY,
                    'section_id' => parent::ID,
                    'given_out' => true,
                    'used' => false,
                ]
            ]);

        $this->semesterRepository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => parent::ID]]);

        $this->semesterRepository->expects($this->once())
            ->method('getOpenQuestionSet')->with(parent::ID)
            ->willReturn(['id' => parent::ID]);

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::KEY_USED, parent::KEY, false);

        Event::shouldReceive('fire')->once()
            ->with(
                Fce\Events\Event::EVALUATION_SUBMITTED,
                [$this->request->evaluations, $this->request->comment, $this->request->semester_id, $this->request->question_set_id],
                false
            );

        $this->assertEquals(
            $this->controller->respondSuccess('Evaluation successfully submitted'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );
    }

    public function testSubmitEvaluationsWithNotGivenOutKey()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'given_out' => false,
                ]
            ]);

        $this->assertEquals(
            $this->controller->respondUnprocessable('This key has not yet been given out'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );
    }

    public function testSubmitEvaluationsWithUsedKey()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'given_out' => true,
                    'used' => true,
                ]
            ]);

        $this->assertEquals(
            $this->controller->respondForbidden('This key has already been used'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );
    }

    public function testSubmitEvaluationsWithIncorrectIds()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(parent::KEY)
            ->willReturn([
                'data' => [
                    'given_out' => true,
                    'used' => false,
                ]
            ]);

        $this->semesterRepository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => parent::ID]]);


        $this->semesterRepository->expects($this->once())
            ->method('getOpenQuestionSet')->with(parent::ID)
            ->willReturn(['id' => parent::ID]);

        $this->assertEquals(
            $this->controller->respondUnprocessable('The semester or question set provided is incorrect'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );
    }

    public function testIncremetEvaluationsException()
    {
        // 404 - Not found
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Key does not exist'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );

        // 500 - Internal server error
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not submit the evaluations'),
            $this->controller->submitEvaluations($this->request, parent::KEY)
        );
    }
}
