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
        $key = $this->keyRepository->getKeyByValue($key)['data'];

        if ($key['given_out']) {
            return $this->respondForbidden('This key has already been given out');
        }

        $semesterId = $this->semesterRepository->getCurrentSemester()['data']['id'];
        $questionSet = $this->semesterRepository->getOpenQuestionSet($semesterId);

        event(Event::KEY_GIVEN_OUT, $key['value']); // The key has been given out.

        return $this->repository->getEvaluationsBySectionAndQuestionSet($key['section_id'], $questionSet['id']);
    }

    /**
     * Submit an evaluation and a comment if present.
     *
     * @param EvaluationRequest $request
     * @param $key
     * @return array
     */
    public function submitEvaluations(EvaluationRequest $request, $key)
    {
        $key = $this->keyRepository->getKeyByValue($key)['data'];

        // Key has not been given out for some reason.
        if (! $key['given_out']) {
            return $this->respondUnprocessable('This key has not yet been given out');
        }

        if ($key['used']) {
            return $this->respondForbidden('This key has already been used');
        }

        $semesterId = $this->semesterRepository->getCurrentSemester()['data']['id'];
        $questionSetId = $this->semesterRepository->getOpenQuestionSet($semesterId)['id'];

        if ($request->semester_id != $semesterId || $request->question_set_id != $questionSetId) {
            return $this->respondUnprocessable('The semester or question set provided is incorrect');
        }

        event(Event::KEY_USED, $key['value']); // The key has been used.
        event(Event::EVALUATION_SUBMITTED, [$request->evaluations, $request->comment, $semesterId, $questionSetId]);

        return $this->respondSuccess('Evaluation successfully submitted');
    }
}
