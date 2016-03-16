<?php
/**
 * Created by BrainMaestro
 * Date: 13/3/2016
 * Time: 1:15 AM
 */

namespace Fce\Listeners;

use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\CommentRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class EvaluationSubmitted implements ShouldQueue
{
    protected $repository;
    protected $commentRepository;

    public function __construct(EvaluationRepository $repository, CommentRepository $commentRepository)
    {
        $this->repository = $repository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($evaluations, $comment, $semesterId, $questionSetId)
    {
        foreach ($evaluations as $evaluation) {
            $this->repository->incrementEvaluation(
                $evaluation['id'],
                $evaluation['column']
            );
        }

        if (!is_null($comment)) {
            $this->commentRepository->createComment($semesterId, $questionSetId, $comment);
        }
    }
}
