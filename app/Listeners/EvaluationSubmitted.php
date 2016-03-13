<?php
/**
 * Created by BrainMaestro
 * Date: 13/3/2016
 * Time: 1:15 AM
 */

namespace Fce\Listeners;

use Fce\Repositories\Contracts\EvaluationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class EvaluationSubmitted implements ShouldQueue
{
    protected $repository;

    public function __construct(EvaluationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        foreach (func_get_args() as $evaluation) {
            $this->repository->incrementEvaluation(
                $evaluation['id'],
                $evaluation['column']
            );
        }
    }
}