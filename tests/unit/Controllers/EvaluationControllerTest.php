<?php
use Fce\Http\Controllers\EvaluationController;
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
    const KEY = 'AAAAAA';

    protected $repository;
    protected $keyRepository;
    protected $semesterRepository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->semesterRepository = $this->getMockBuilder(SemesterRepository::class)->getMock();

        $this->controller = new EvaluationController($this->repository, $this->keyRepository, $this->semesterRepository);
    }

    public function testIndex()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(self::KEY)
            ->willReturn([
                'data' => [
                    'value' => self::KEY,
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
            ->with(Fce\Events\Event::KEY_GIVEN_OUT, self::KEY, false);

        $this->repository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')
            ->with(parent::ID, parent::ID);

        $this->controller->index(self::KEY);
    }

    public function testIndexWithGivenOutKey()
    {
        $this->keyRepository->expects($this->once())
            ->method('getKeyByValue')->with(self::KEY)
            ->willReturn([
                'data' => [
                    'given_out' => true,
                ]
            ]);

        $this->assertEquals(
            $this->controller->respondForbidden('This key has already been given out'),
            $this->controller->index(self::KEY)
        );
    }

    public function testIndexException()
    {
        // 404 - Not found
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Key does not exist'),
            $this->controller->index(self::KEY)
        );

        // 500 - Internal server error
        $this->keyRepository->method('getKeyByValue')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list the evaluations'),
            $this->controller->index(self::KEY)
        );
    }
}
