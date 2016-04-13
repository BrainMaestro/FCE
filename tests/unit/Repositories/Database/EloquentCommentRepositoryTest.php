<?php

use Fce\Repositories\Database\EloquentCommentRepository;

/**
 * Created by BrainMaestro
 * Date: 12/2/2016
 * Time: 11:16 PM.
 */
class EloquentCommentRepositoryTest extends TestCase
{
    protected $repository;
    protected $questionSet;
    protected $section;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentCommentRepository(
            new \Fce\Models\Comment,
            new \Fce\Transformers\CommentTransformer
        );

        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $this->section = factory(Fce\Models\Section::class)->create();
    }

    public function testGetComments()
    {
        $comments = factory(Fce\Models\Comment::class, 5)->create([
            'section_id' => $this->section->id,
            'question_set_id' => $this->questionSet->id,
        ]);
        $comments = $this->repository->transform($comments)['data'];

        $allComments = $this->repository->getComments(
            $this->section->id,
            $this->questionSet->id
        );

        $this->assertCount(count($comments), $allComments['data']);
        $this->assertEquals($comments, $allComments['data']);
    }

    public function testAddComment()
    {
        $attributes = factory(Fce\Models\Comment::class)->make([
            'section_id' => $this->section->id,
            'question_set_id' => $this->questionSet->id,
        ])->toArray();

        $comment = $this->repository->createComment(
            $attributes['section_id'],
            $attributes['question_set_id'],
            $attributes['comment']
        )['data'];

        $this->assertEquals($attributes['comment'], $comment['comment']);
    }
}
