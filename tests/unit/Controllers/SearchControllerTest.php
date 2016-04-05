<?php

use Fce\Http\Controllers\SearchController;
use Fce\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 3/13/2016
 * Time: 2:05 PM.
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
}
