<?php

use App\Admin;
use App\Role;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::where('email', 'admin@annanovas.com')->get();

        if ($admin->count() == 0) {
            $admin = Admin::updateOrCreate(
                [
                    'email' => 'admin@annanovas.com',
                ],
                [
                    'name' => 'Admin',
                    'role_id'=> 1,
                    'email' => 'admin@annanovas.com',
                    'password' => bcrypt('111111'),
                    'status' => 1

                ]
            );

            if ($admin->wasRecentlyCreated) {
                $admin->attachRole($admin->role_id);
            }
        }


        // $admin->attachRole(Role::first()->id);

    }
}
