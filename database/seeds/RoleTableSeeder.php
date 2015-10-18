<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')
            ->insert([
                [
                    'role' => 'admin',
                    'display_name' => 'Administrator'
                ],
                [
                    'role' => 'dean',
                    'display_name' => 'Dean'
                ],
                [
                    'role' => 'executive',
                    'display_name' => 'Executive'
                ],
                [
                    'role' => 'faculty',
                    'display_name' => 'Faculty'
                ],
                [
                    'role' => 'secretary',
                    'display_name' => 'Secretary'
                ],
                [
                    'role' => 'helper',
                    'display_name' => 'Helper'
                ]
            ]);
    }
}
