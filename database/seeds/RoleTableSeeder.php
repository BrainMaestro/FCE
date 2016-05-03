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
                    'name' => 'admin',
                    'display_name' => 'Administrator',
                ],
                [
                    'name' => 'sas-dean',
                    'display_name' => 'SAS Dean',
                ],
                [
                    'name' => 'sbe-dean',
                    'display_name' => 'SBE Dean',
                ],
                [
                    'name' => 'sitc-dean',
                    'display_name' => 'SITC Dean',
                ],
                [
                    'name' => 'executive',
                    'display_name' => 'Executive',
                ],
                [
                    'name' => 'faculty',
                    'display_name' => 'Faculty',
                ],
                [
                    'name' => 'secretary',
                    'display_name' => 'Secretary',
                ],
                [
                    'name' => 'helper',
                    'display_name' => 'Helper',
                ],
            ]);
    }
}
