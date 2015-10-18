<?php

use Illuminate\Database\Seeder;

class QuestionMetadataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_metadatas')
            ->insert([
                [
                    'question_id' => 1,
                    'number' => 1,
                    'category' => '',
                    'title' => 'Professor\'s Adherence to time',
                    'description' => '(Professor arrives in the classroom on time.)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 2,
                    'category' => '',
                    'title' => 'Professor\'s preparedness to Teach',
                    'description' => '(My professor arrives in the classroom prepared)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 3,
                    'category' => '',
                    'title' => 'Professor\'s Accessibility in Class',
                    'description' => '(My professor is accessible in class)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 4,
                    'category' => '',
                    'title' => 'Professor\'s Availability outside the Classroom',
                    'description' => '(My professor is available during office hours)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 5,
                    'category' => '',
                    'title' => 'Asking Questions in Class',
                    'description' => '(I feel comfortable asking questions during class)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 6,
                    'category' => '',
                    'title' => 'Explanation of Concepts',
                    'description' => '(My professor explains the material and concepts well)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 7,
                    'category' => '',
                    'title' => 'Professor\'s Teaching Consistency',
                    'description' => '(My professor is consistent in his/her teaching )',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 8,
                    'category' => '',
                    'title' => 'Use of e-Book',
                    'description' => '(My professor uses e-books)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 9,
                    'category' => '',
                    'title' => 'Use of Digital Instructional Technologies',
                    'description' =>
                        '(My professor uses other digital instructional technology such as Electronic Journal '.
                        'Articles, Youtube, TED Talks, computer programs, videos, online resources, or social media)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 10,
                    'category' => '',
                    'title' => 'Learning compliance with the Syllabus',
                    'description' => '(I am learning what is in the course description/syllabus)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 11,
                    'category' => '',
                    'title' => 'Use of Digital Skills',
                    'description' => '(I am using digital and other on-line skills in this course)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 12,
                    'category' => '',
                    'title' => 'Relevance of Assignments',
                    'description' => '(My professor’s assignments are relevant to the course)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 13,
                    'category' => '',
                    'title' => 'Grading Policies',
                    'description' => 'My professors grading policies are fair and consistent with the syllabus',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 14,
                    'category' => '',
                    'title' => 'Relevance of Course content to future career prospects',
                    'description' => 'My professor relates course content and skills to my future career',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 1,
                    'number' => 15,
                    'category' => '',
                    'title' => 'American Style Education',
                    'description' => 'My professor teaches in accordance with the interactive American style '.
                        'of education that is the way AUN claims to be different',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 1,
                    'category' => 'course',
                    'title' => 'Organization',
                    'description' => '(Course was well organized, material was presented in a logical sequence, '.
                        'instructional time was used effectively and important points emphasized.',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 2,
                    'category' => 'course',
                    'title' => 'Learning Outcomes and Objectives',
                    'description' => '(Goals and educational objectives were clear, faculty expectations of '.
                        'students were clear, grading policy was clearly explained)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 3,
                    'category' => 'course',
                    'title' => 'Content',
                    'description' => '(Course content facilitated student ability to achieve course goals'.
                        ' and objectives, and when applicable, was relevant to career preparation)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 4,
                    'category' => 'course',
                    'title' => 'Assessment',
                    'description' => '(Material on exams was related to material covered either in class '.
                        'or in course assignments, students were treated equitably)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 5,
                    'category' => 'course',
                    'title' => 'Overall',
                    'description' => '(The course objectives were met)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 6,
                    'category' => 'instructor',
                    'title' => 'Organization',
                    'description' => '(Instructor presented material in an organized fashion; emphasized'.
                        ' important points)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 7,
                    'category' => 'instructor',
                    'title' => 'Clarity',
                    'description' => '(Instructor communicated effectively, explained well, presented content'.
                        ' clearly, and gave comprehensible response to  questions)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 8,
                    'category' => 'instructor',
                    'title' => 'Enthusiasm',
                    'description' => '(Instructor was dynamic and energetic, stimulated learner interest,'.
                        ' and enjoyed teaching)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 9,
                    'category' => 'instructor',
                    'title' => 'Up to Date',
                    'description' => '(Instructor discussed recent development in the field, directed students'.
                        ' to current reference materials, and provided additional materials to cover current topics)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 10,
                    'category' => 'instructor',
                    'title' => 'Contribution',
                    'description' => '(Instructor discussed recent development in the field, directed students'.
                        ' to current reference materials, and provided additional materials to cover current topics)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 11,
                    'category' => 'instructor',
                    'title' => 'Professionalism',
                    'description' => '(Instructor demonstrated role model qualities that were of use to students)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 12,
                    'category' => 'instructor',
                    'title' => 'Attitude',
                    'description' => '(Instructor was concerned about students learning the material, encourages'.
                        ' class participation, was receptive to different perspectives)',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 13,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I attended and participated in class sessions',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 14,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I completed assignments on time',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 15,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I learned the required information for the course',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 16,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I used my laptop and technology successfully in this course.',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 17,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I used the library as part of this class',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'question_id' => 2,
                    'number' => 18,
                    'category' => 'student',
                    'title' => '',
                    'description' => 'I used at least one learning support program (writing center, math,'.
                        ' lab, tutor, etc)',
                    'created_at' => '0000-00-00 00:00:00'
                ]
            ]);
    }
}
