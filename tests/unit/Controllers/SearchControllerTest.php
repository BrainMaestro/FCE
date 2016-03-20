<?php
use Fce\Http\Controllers\SearchController;
use Fce\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 3/13/2016
 * Time: 2:05 PM
 */
class SearchControllerTest extends TestCase
{
    protected $controller;
    protected $request;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new SearchController;
        $this->request = new SearchRequest;

        // Default model
        $this->request->model = 'user';
        factory(Fce\Models\User::class)->create();
    }

    public function testIndex()
    {
        factory(Fce\Models\User::class, 2)->create();
        $this->assertCount(3, $this->controller->index($this->request)['data']);

        $user = app(Fce\Repositories\Contracts\UserRepository::class)
            ->transform(Fce\Models\User::first())['data'];
        Input::merge(['query' => 'email:' . $user['email']]);

        $this->assertEquals(
            $user,
            $this->controller->index($this->request)['data'][0]
        );
    }

    public function testIndexModelNotFoundException()
    {
        Input::merge(['query' => 'email:not_an_email_$%^&*']);

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find any users, that meet the search criteria'),
            $this->controller->index($this->request)
        );
    }

    public function testIndexReflectionException()
    {
        $this->request->model = 'not_a_model';

        $this->assertEquals(
            $this->controller->respondUnprocessable('Model does not exist or cannot be searched'),
            $this->controller->index($this->request)
        );
    }

    public function testIndexException()
    {
        $controller = $this->getMockBuilder(SearchController::class)
            ->setMethods(['setRepository'])
            ->getMock();
        $controller->expects($this->once())
            ->method('setRepository')
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not complete search, an error occurred'),
            $controller->index($this->request)
        );
    }
}
