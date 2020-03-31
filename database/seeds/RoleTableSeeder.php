<?php

use App\Role;
use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::updateOrCreate(
            [
                'name' => 'admin',
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin Role',
                'type' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        $role = Role::updateOrCreate(
            [
                'name' => 'custom',
            ],
            [
                'name' => 'custom',
                'display_name' => 'Custom',
                'description' => 'Custom Role',
                'type' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // $admin = new Role();
        // $admin->name         = 'admin';
        // $admin->display_name = 'Super Administrator'; // optional
        // $admin->description  = 'User is allowed to manage and edit other users'; // optional
        // $admin->type  = 'admin'; // optional
        // $admin->save();
    }
}
