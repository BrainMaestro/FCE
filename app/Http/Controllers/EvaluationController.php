<?php

namespace Fce\Http\Controllers;

use Fce\Events\Event;
use Fce\Http\Requests\EvaluationRequest;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EvaluationController extends Controller
{
    protected $repository;

    protected $keyRepository;

    protected $semesterRepository;

    public function __construct(
        EvaluationRepository $repository,
        KeyRepository $keyRepository,
        SemesterRepository $semesterRepository
    ) {
        $this->repository = $repository;
        $this->keyRepository = $keyRepository;
        $this->semesterRepository = $semesterRepository;
    }

    /**
     * Get evaluations by the specified key.
     *
     * @param $key
     * @return array
     */
    public function index($key)
    {
        try {
            $key = $this->keyRepository->getKeyByValue($key)['data'];

            if ($key['given_out']) {
                return $this->respondForbidden('This key has already been given out');
            }

            $semesterId = $this->semesterRepository->getCurrentSemester()['data']['id'];
            $questionSet = $this->semesterRepository->getOpenQuestionSet($semesterId);

            event(Event::KEY_GIVEN_OUT, $key['value']); // The key has been given out.

            return $this->repository->getEvaluationsBySectionAndQuestionSet($key['section_id'], $questionSet['id']);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Key does not exist');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list the evaluations');
        }
    }

    public function show($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }
}
