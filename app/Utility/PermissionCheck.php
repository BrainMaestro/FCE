<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 4/23/2016
 * Time: 6:26 PM.
 */
namespace Fce\Utility;

use Illuminate\Support\Facades\Auth;

trait PermissionCheck
{
    protected $repository;

    protected $userData;

    /**
     * Base permission method which calls the right permission method based on path.
     *
     * @param $request
     * @return bool
     */
    public function checkPermission($request)
    {
        try {
            $path = $request->path();

            switch ($path) {
                case str_is('api/search', $path):
                    return Auth::check();
                case str_is('api/users*', $path):
                    return $this->checkUserRoutePermissions($path, $request);
                case str_is('api/sections*', $path):
                    return $this->checkSectionRoutePermissions($path, $request);
                case str_is('api/questions*', $path):
                    return $this->checkQuestionsRoutePermissions($path, $request);
                case str_is('api/question_sets*', $path):
                    return $this->checkQuestionSetRoutePermissions($path, $request);
                case str_is('api/schools*', $path):
                    return $this->checkSchoolRoutePermissions($path, $request);
                case str_is('api/semesters*', $path):
                    return $this->checkSemesterRoutePermissions($path, $request);
                default:
                    return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check a users permission for a user resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkUserRoutePermissions($path, $request)
    {
        $resourceUserId = $request->id;
        $userRepository = $this->getRepository('user');
        $user = Auth::user();
        $authUserData = $this->getUserData();

        try {
            $resourceUserData = $userRepository->getUserById($resourceUserId);
        } catch (\Exception $e) {
            $resourceUserData = -1;
        }

        switch ($path) {
            case 'api/users':
                if ($request->school && $user->can('view-user-dean')) {
                    return $this->checkSchools($authUserData, $resourceUserData, $request->school);
                }

                return $user->can(['view-users', 'create-user']);

            case str_is('api/users/*', $path):
                if ($request->method() == 'GET') {
                    if ($user->can('view-users')) {
                        return true;
                    } elseif ($user->can('view-user-dean')) {
                        return $this->checkSchools($authUserData, $resourceUserData);
                    } elseif ($user->can('view-current-user')) {
                        return $authUserData['data']['id'] == $resourceUserId;
                    } else {
                        return false;
                    }
                }

                if ($request->method() == 'DELETE') {
                    return $user->can('delete-user');
                }

                if ($request->method() == 'PUT') {
                    return $user->can('update-user');
                }

                return false;

            default:
                return false;
        }
    }

    /**
     * Check a users permission for a section resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkSectionRoutePermissions($path, $request)
    {
        $sectionRepository = $this->getRepository('section');
        $user = Auth::user();
        $authUserData = $this->getUserData();

        try {
            $resourceSectionData = $sectionRepository->getSectionById($request->id);
        } catch (\Exception $e) {
            $resourceSectionData = -1;
        }

        switch ($path) {
            case 'api/sections':
                if ($request->school && $user->can('view-sections-dean')) {
                    return $this->checkSchools($authUserData, $resourceSectionData, $request->school);
                }

                return $user->can(['view-sections', 'create-sections']);

            case str_is('api/sections/*/status', $path):
                return $user->can('update-section');

            case str_is('api/sections/*/keys', $path):
                return $user->can('view-all-keys');

            case str_is('api/sections/*/reports', $path) || str_is('api/sections/*/report/*', $path):
                if ($user->can('view-all-reports')) {
                    return true;
                } elseif ($user->can('view-report-dean')) {
                    return $this->checkSection($authUserData, $resourceSectionData);
                } elseif ($user->can('view-section-report')) {
                    return $this->checkSection($authUserData, $resourceSectionData, true);
                } else {
                    return false;
                }

            case str_is('api/sections/*', $path):
                if ($request->method() == 'GET') {
                    if ($user->can('view-sections')) {
                        return true;
                    } elseif ($user->can('view-sections-dean')) {
                        return $this->checkSection($authUserData, $resourceSectionData);
                    } elseif ($user->can('view-users-sections')) {
                        return $this->checkSection($authUserData, $resourceSectionData, true);
                    } else {
                        return false;
                    }
                }

                if ($request->method() == 'DELETE') {
                    return $user->can('delete-user');
                }

                if ($request->method() == 'PUT') {
                    return $user->can('update-section');
                }

                return false;

            default:
                return false;
        }
    }

    /**
     * Check a users permission for a question resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkQuestionsRoutePermissions($path, $request)
    {
        $user = Auth::user();

        return $user->can(['view-questions', 'create-questions']);
    }

    /**
     * Check a users permission for a question-set resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkQuestionSetRoutePermissions($path, $request)
    {
        $user = Auth::user();

        switch ($path) {
            case 'api/question_sets':
                return $user->can(['view-question-sets', 'create-question-sets']);

            case str_is('api/question_sets/*/questions', $path):
                return $user->can('add-question-sets-questions');

            case str_is('api/question_sets/*', $path):
                return $user->can('view-question-sets');

            default:
                return false;
        }
    }

    /**
     * Check a users permission for a school resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkSchoolRoutePermissions($path, $request)
    {
        $resourceSchoolId = $request->id;
        $authUserData = $this->getUserData();
        $user = Auth::user();

        switch ($path) {
            case 'api/schools':
                return $user->can(['view-schools', 'create-school']);
            case str_is('api/schools/*', $path):
                if ($request->method() == 'GET') {
                    if ($user->can('view-schools')) {
                        return true;
                    } elseif ($user->can('view-school-dean')) {
                        return $this->checkSchools($authUserData, null, $resourceSchoolId);
                    } else {
                        return false;
                    }
                }

                if ($request->method() == 'PUT') {
                    return $user->can('update-school');
                }

                return false;

            default:
                return false;
        }
    }

    /**
     * Check a users permission for a semester resource.
     *
     * @param $path
     * @param $request
     * @return bool
     */
    protected function checkSemesterRoutePermissions($path, $request)
    {
        $user = Auth::user();

        switch ($path) {
            case 'api/semesters':
                return $user->can(['view-semesters', 'create-semesters']);

            case str_is('api/semesters/*/question_sets', $path):
                return $user->can('add-semester-questions');

            case str_is('api/semesters/*/question_sets/*', $path):
                return $user->can('update-semester-question');

            case str_is('api/semesters/*', $path):
                return $user->can('update-semesters');

            default:
                return false;

        }
    }

    /**
     * Allows repositories to be gotten dynamically.
     *
     * @param $model
     * @return mixed
     */
    private function getRepository($model)
    {
        $this->repository = app('Fce\\Repositories\\Contracts\\' . ucfirst($model) . 'Repository');

        return $this->repository;
    }

    /**
     * Gets the logged in user's data.
     *
     * @return mixed
     */
    private function getUserData()
    {
        $this->userData = $this->getRepository('user')->getUserById(Auth::user()->id);

        return $this->userData;
    }

    /**
     * Checks if logged user belongs to the same school as the resource.
     *
     * @param $user
     * @param $resourceUser
     * @param bool $schoolId
     * @return bool
     */
    private function checkSchools($user, $resourceUser, $schoolId = false)
    {
        if ($schoolId) {
            foreach ($user['data']['schools']['data'] as $school) {
                if ($school['id'] == $schoolId) {
                    return true;
                }
            }

            return false;
        }

        if ($resourceUser == -1) {
            return true;
        }

        foreach ($user['data']['schools']['data'] as $school) {
            if (in_array($school, $resourceUser['data']['schools']['data'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if user or school is in section.
     *
     * @param $user
     * @param $resourceSection
     * @param bool $userSection
     * @return bool
     */
    private function checkSection($user, $resourceSection, $userSection = false)
    {
        if ($userSection) {
            if (in_array($user['data'], $resourceSection['data']['users']['data'])) {
                return true;
            }

            return false;
        }

        if ($resourceSection == -1) {
            return true;
        }

        foreach ($user['data']['schools']['data'] as $school) {
            if ($school['id'] == $resourceSection['data']['school_id']) {
                return true;
            }
        }

        return false;
    }
}
