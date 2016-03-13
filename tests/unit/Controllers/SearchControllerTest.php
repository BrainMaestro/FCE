<?php
use Fce\Http\Controllers\SearchController;
use Fce\Http\Requests\SearchRequest;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 3/13/2016
 * Time: 2:05 PM
 */
class SearchControllerTest extends TestCase
{
    protected $mock;
    protected $controller;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new SearchController();
        $this->user = factory(Fce\Models\User::class)->create();
    }

    public function testIndex()
    {
        $request = new SearchRequest();
        $request->merge(['model' => 'user', 'query' => 'email:@']);

        $mock = $this->getMockBuilder(SearchController::class)->setMethods(['index', 'setRepository'])->getMock();
        $mock->expects($this->once())->method('setRepository')->with('user');

        $this->controller->index($request);
    }

//    public function testIndexThrowableException()
//    {
//        $this->assertEquals(
//            $this->controller->respondUnprocessable("Model doesn't exist or can't be searched"),
//            $this->controller->index()
//        );
//    }
//
//    public function testIndexModelNotFoundException()
//    {
//        $this->assertEquals(
//            $this->controller->respondNotFound("Could not find any users, that meet the search criteria"),
//            $this->controller->index()
//        );
//    }
//
//    public function testIndexException()
//    {
//        $this->assertEquals(
//            $this->controller->respondInternalServerError("Could not complete search, an error occurred"),
//            $this->controller->index()
//        );
//    }
}