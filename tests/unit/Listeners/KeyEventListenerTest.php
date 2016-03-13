<?php
use Fce\Listeners\KeyEventListener;
use Fce\Repositories\Contracts\KeyRepository;

/**
 * Created by BrainMaestro
 * Date: 13/3/2016
 * Time: 2:18 AM
 */
class KeyEventListenerTest extends TestCase
{
    protected $repository;
    protected $listener;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(KeyRepository::class)->getMock();

        $this->listener = new KeyEventListener($this->repository);
    }

    public function testOnKeyGivenOut()
    {
        $this->repository->expects($this->once())
            ->method('setGivenOut')->with(parent::KEY);

        $this->listener->onKeyGivenOut(parent::KEY);
    }

    public function testOnKeyUsed()
    {
        $this->repository->expects($this->once())
            ->method('setUsed')->with(parent::KEY);

        $this->listener->onKeyUsed(parent::KEY);
    }
}
