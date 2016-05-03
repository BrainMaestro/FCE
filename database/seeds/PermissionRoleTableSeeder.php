<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Fce\Models\Role::first()->permissions()->attach(\Fce\Models\Permission::all());
        \Fce\Models\Role::all()[1]->permissions()->attach([2, 3, 8, 9, 14, 16, 23]);
        \Fce\Models\Role::all()[2]->permissions()->attach([2, 3, 8, 9, 14, 16, 23]);
        \Fce\Models\Role::all()[3]->permissions()->attach([2, 3, 8, 9, 14, 16, 23]);
        \Fce\Models\Role::all()[4]->permissions()->attach([1, 2, 3, 7, 8, 9, 14, 15, 16, 22, 23]);
        \Fce\Models\Role::all()[5]->permissions()->attach([2, 8, 14]);
        \Fce\Models\Role::all()[6]->permissions()->attach([11, 13]);
        \Fce\Models\Role::all()[7]->permissions()->attach([11, 13]);
    }
}
