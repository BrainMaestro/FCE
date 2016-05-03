<?php

use Fce\Models\Section;
use Fce\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 4/27/2016
 * Time: 7:42 PM.
 */
class PermissionCheckTest extends TestCase
{
    protected $adminUser;
    protected $deanUser;
    protected $facultyUser;
    protected $helperUser;
    protected $section;
    protected $permissionCheck;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');

        $this->adminUser = factory(User::class)->create();
        User::where('id', $this->adminUser->id)->first()->roles()->attach(1);

        $this->deanUser = factory(User::class)->create();
        User::where('id', $this->deanUser->id)->first()->roles()->attach(2);
        User::where('id', $this->deanUser->id)->first()->schools()->attach(1);

        $this->facultyUser = factory(User::class)->create();
        User::where('id', $this->facultyUser->id)->first()->roles()->attach(6);
        User::where('id', $this->facultyUser->id)->first()->schools()->attach(1);

        $this->helperUser = factory(User::class)->create();
        User::where('id', $this->helperUser->id)->first()->roles()->attach(8);

        $this->section = factory(Section::class)->create();
        Section::where('id', $this->section->id)->first()->users()->attach($this->facultyUser->id);
    }

    public function routeProvider()
    {
        return [
            ['api/search', 'fakeMethod', 'GET'],
            ['api/users', 'checkUserRoutePermissions', 'GET'],
            ['api/users/1', 'checkUserRoutePermissions', 'GET'],
            ['api/users', 'checkUserRoutePermissions', 'POST'],
            ['api/users/1', 'checkUserRoutePermissions', 'DELETE'],
            ['api/users/1', 'checkUserRoutePermissions', 'PUT'],
            ['api/sections', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections', 'checkSectionRoutePermissions', 'POST'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'PUT'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'DELETE'],
            ['api/sections/1/status', 'checkSectionRoutePermissions', 'PATCH'],
            ['api/sections/1/keys', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/reports', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/report/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/questions', 'checkQuestionsRoutePermissions', 'GET'],
            ['api/questions/1', 'checkQuestionsRoutePermissions', 'GET'],
            ['api/questions', 'checkQuestionsRoutePermissions', 'POST'],
            ['api/question_sets', 'checkQuestionSetRoutePermissions', 'GET'],
            ['api/question_sets/1', 'checkQuestionSetRoutePermissions', 'GET'],
            ['api/question_sets', 'checkQuestionSetRoutePermissions', 'POST'],
            ['api/question_sets/1/questions', 'checkQuestionSetRoutePermissions', 'POST'],
            ['api/schools', 'checkSchoolRoutePermissions', 'GET'],
            ['api/schools/1', 'checkSchoolRoutePermissions', 'GET'],
            ['api/schools', 'checkSchoolRoutePermissions', 'POST'],
            ['api/schools/1', 'checkSchoolRoutePermissions', 'PUT'],
            ['api/semesters', 'checkSemesterRoutePermissions', 'GET'],
            ['api/semesters', 'checkSemesterRoutePermissions', 'POST'],
            ['api/semesters/1', 'checkSemesterRoutePermissions', 'PUT'],
            ['api/semesters/1/question_sets', 'checkSemesterRoutePermissions', 'POST'],
            ['api/semesters/1/question_sets/1', 'checkSemesterRoutePermissions', 'PUT'],
        ];
    }

    /**
     * @dataProvider routeProvider
     */
    public function testAdminUser($route, $method, $type)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->adminUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertTrue($result);
    }

    public function deanRouteProvider()
    {
        return [
            ['api/search', 'fakeMethod', 'GET'],
            ['api/users', 'checkUserRoutePermissions', 'GET'],
            ['api/users/1', 'checkUserRoutePermissions', 'GET'],
            ['api/sections', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/reports', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/report/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/schools/1', 'checkSchoolRoutePermissions', 'GET'],
        ];
    }

    /**
     * @dataProvider deanRouteProvider
     */
    public function testDeanUser($route, $method, $type)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->deanUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);
        $request->id = 1;
        $request->school = 1;

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertTrue($result);
    }

    public function facultyRouteProvider()
    {
        return [
            ['api/search', 'fakeMethod', 'GET'],
            ['api/users/1', 'checkUserRoutePermissions', 'GET'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/reports', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/report/1', 'checkSectionRoutePermissions', 'GET'],
        ];
    }

    /**
     * @dataProvider facultyRouteProvider
     */
    public function testFacultyUser($route, $method, $type)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->facultyUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);

        if (str_is('api/users/1', $route)) {
            $request->id = $this->facultyUser->id;
        }

        if (str_is('api/sections/*', $route)) {
            $request->id = $this->section->id;
        }

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertTrue($result);
    }

    public function falseRouteProvider()
    {
        return [
            ['api', 'fakeMethod', 'GET'],
            ['api/users/a', 'checkUserRoutePermissions', 'GET'],
            ['api/users/1', 'checkUserRoutePermissions', 'PATCH'],
            ['api/users*', 'checkUserRoutePermissions', 'PATCH'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1', 'checkSectionRoutePermissions', 'PATCH'],
            ['api/sections*', 'checkSectionRoutePermissions', 'PATCH'],
            ['api/sections/1/reports', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/1/report/1', 'checkSectionRoutePermissions', 'GET'],
            ['api/question_sets*', 'checkQuestionSetRoutePermissions', 'POST'],
            ['api/schools/a', 'checkSchoolRoutePermissions', 'GET'],
            ['api/schools*', 'checkSchoolRoutePermissions', 'GET'],
            ['api/schools/*', 'checkSchoolRoutePermissions', 'PATCH'],
            ['api/semesters*', 'checkSemesterRoutePermissions', 'GET'],
        ];
    }

    /**
     * @dataProvider falseRouteProvider
     */
    public function testFalseRoutes($route, $method, $type)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->helperUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertFalse($result);
    }

    public function sectionSchoolFalseRouteProvider()
    {
        return [
            ['api/users/*', 'checkUserRoutePermissions', 'GET'],
            ['api/sections/a/reports', 'checkSectionRoutePermissions', 'GET'],
            ['api/sections/a/report/1', 'checkSectionRoutePermissions', 'GET'],
        ];
    }

    /**
     * @dataProvider sectionSchoolFalseRouteProvider
     */
    public function testFalseSectionSchool($route, $method, $type)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->deanUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);
        $request->school = 'a';
        $request->id = 'a';

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertTrue($result);
    }

    public function testSchoolFalseProvider()
    {
        return [
            ['api/sections', 'checkUserRoutePermissions', 'GET', 'a'],
            ['api/users/1', 'checkSchoolRoutePermissions', 'GET', null],
        ];
    }

    /**
     * @dataProvider testSchoolFalseProvider
     */
    public function testSchoolFalse($route, $method, $type, $id)
    {
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($this->deanUser);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);
        $request->school = $id;
        $request->id = $id;
        if (str_is('api/users/1', $route)) {
            $request->id = $this->adminUser->id;
        }

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertFalse($result);
    }

    public function testSectionFalseProvider()
    {
        return [
            ['api/sections/1', 'checkUserRoutePermissions', 'GET', false],
            ['api/sections/1', 'checkUserRoutePermissions', 'GET', true],
        ];
    }

    /**
     * @dataProvider testSectionFalseProvider
     */
    public function testSectionFalse($route, $method, $type, $dean)
    {
        $user = $this->facultyUser;
        if ($dean) {
            $user = $this->deanUser;
            $user->schools()->detach(1);
        } else {
            $user->sections()->detach($this->section->id);
        }
        Auth::shouldReceive('user')->zeroOrMoreTimes()->andreturn($user);
        Auth::shouldReceive('check')->zeroOrMoreTimes()->andreturn(true);

        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn($route);
        $request->expects($this->any())->method('method')->willReturn($type);
        $request->id = $this->section->id;

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method($method)
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertFalse($result);
    }

    public function testException()
    {
        $request = $this->getMock(\Illuminate\Http\Request::class, ['path', 'method']);
        $request->expects($this->any())->method('path')->willReturn('api/sections');
        $request->expects($this->any())->method('method')->willReturn('GET');
        $request->school = 'a';
        $request->id = 'a';

        $this->permissionCheck = $this->getMockForTrait(\Fce\Utility\PermissionCheck::class);
        $this->permissionCheck->expects($this->any())
            ->method('checkUserRoutePermissions')
            ->willReturn(true);

        $result = $this->permissionCheck->checkPermission($request);
        $this->assertFalse($result);
    }
}
