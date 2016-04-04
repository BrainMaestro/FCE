<?php
use Fce\Http\Controllers\Auth\AuthController;

/**
 * Created by BrainMaestro.
 * Date: 4/4/16
 * Time: 3:34 PM.
 */
class AuthControllerTest extends TestCase
{
    protected $controller;
    protected $request;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new AuthController();
        $this->request = new \Illuminate\Http\Request();
        $this->request->merge([
            'email' => factory(Fce\Models\User::class)->create()->email,
        ]);
    }

    public function testLogin()
    {
        $this->request->merge(['password' => 'password']);
        $response = $this->controller->login($this->request)->getData(true)['data'];

        $this->assertArrayHasKey(
            'token',
            $response
        );
    }

    public function testLoginFailureWithWrongPassword()
    {
        $this->request->merge(['password' => 'wrong_password']);

        $this->assertEquals(
            $this->controller->respondUnauthorized('Your login details are incorrect'),
            $this->controller->login($this->request)
        );
    }

    public function testLogoutWithoutToken()
    {
        $this->assertEquals(
            $this->controller->respondInternalServerError('Logout Unsuccessful'),
            $this->controller->logout()
        );
    }
}
