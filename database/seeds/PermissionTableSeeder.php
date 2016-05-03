<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')
            ->insert([
                [
                    'name' => 'view-users',
                    'display_name' => 'View Users',
                    'description' => 'User is allowed to view all users',
                ],
                [
                    'name' => 'view-current-user',
                    'display_name' => 'View Current User',
                    'description' => 'User is allowed to view himself',
                ],
                [
                    'name' => 'view-user-dean',
                    'display_name' => 'View User Dean',
                    'description' => 'User is allowed to view user in their school',
                ],
                [
                    'name' => 'create-user',
                    'display_name' => 'Create User',
                    'description' => 'User is allowed to create a new user',
                ],
                [
                    'name' => 'delete-user',
                    'display_name' => 'Delete User',
                    'description' => 'User is allowed to delete a user',
                ],
                [
                    'name' => 'update-user',
                    'display_name' => 'Update User',
                    'description' => 'User is allowed to update a user',
                ],
                [
                    'name' => 'view-sections',
                    'display_name' => 'View Sections',
                    'description' => 'User is allowed to view all sections',
                ],
                [
                    'name' => 'view-users-sections',
                    'display_name' => 'View Users Sections',
                    'description' => 'User is allowed to view sections including user ',
                ],
                [
                    'name' => 'view-sections-dean',
                    'display_name' => 'View Section Dean',
                    'description' => 'User is allowed to view sections in their school',
                ],
                [
                    'name' => 'create-section',
                    'display_name' => 'Create Section',
                    'description' => 'User is allowed to create a new section',
                ],
                [
                    'name' => 'update-section',
                    'display_name' => 'Update Section',
                    'description' => 'User is allowed to update a section',
                ],
                [
                    'name' => 'view-section-key',
                    'display_name' => 'View Section Key',
                    'description' => 'User is allowed to view keys for a particular section',
                ],
                [
                    'name' => 'view-all-keys',
                    'display_name' => 'View All Keys',
                    'description' => 'User is allowed to view all section keys',
                ],
                [
                    'name' => 'view-section-report',
                    'display_name' => 'View Section Report',
                    'description' => 'User is allowed to view report for a section that he belongs to',
                ],
                [
                    'name' => 'view-all-reports',
                    'display_name' => 'View All Reports',
                    'description' => 'User is allowed to view all section reports',
                ],
                [
                    'name' => 'view-report-dean',
                    'display_name' => 'View Report Dean',
                    'description' => 'User is allowed to view section reports for their school',
                ],
                [
                    'name' => 'view-questions',
                    'display_name' => 'View Questions',
                    'description' => 'User is allowed to view evaluation questions',
                ],
                [
                    'name' => 'create-questions',
                    'display_name' => 'Create Questions',
                    'description' => 'User is allowed to create evaluation questions',
                ],
                [
                    'name' => 'view-question-sets',
                    'display_name' => 'View Question Sets',
                    'description' => 'User is allowed to view evaluation question sets',
                ],
                [
                    'name' => 'create-question-sets',
                    'display_name' => 'Create Question Sets',
                    'description' => 'User is allowed to create evaluation question sets',
                ],
                [
                    'name' => 'add-question-sets-questions',
                    'display_name' => 'Add Question Sets Questions',
                    'description' => 'User is allowed to add evaluation questions to question sets',
                ],
                [
                    'name' => 'view-schools',
                    'display_name' => 'View Schools',
                    'description' => 'User is allowed to view all schools',
                ],
                [
                    'name' => 'view-school-dean',
                    'display_name' => 'View School Dean',
                    'description' => 'User is allowed to view his school as a dean',
                ],
                [
                    'name' => 'create-school',
                    'display_name' => 'Create School',
                    'description' => 'User is allowed to create school',
                ],
                [
                    'name' => 'update-school',
                    'display_name' => 'Update School',
                    'description' => 'User is allowed to update school',
                ],
                [
                    'name' => 'view-semesters',
                    'display_name' => 'View Semesters',
                    'description' => 'User is allowed to view semesters',
                ],
                [
                    'name' => 'create-semesters',
                    'display_name' => 'Create Semesters',
                    'description' => 'User is allowed to create semesters',
                ],
                [
                    'name' => 'update-semesters',
                    'display_name' => 'Update Semesters',
                    'description' => 'User is allowed to update semesters',
                ],
                [
                    'name' => 'add-semester-questions',
                    'display_name' => 'Add Semester Questions',
                    'description' => 'User is allowed to add question to be used in a semester',
                ],
                [
                    'name' => 'update-semester-question',
                    'display_name' => 'Update Semester Question',
                    'description' => 'User is allowed to update question used in a semester',
                ],
            ]);
    }
}
