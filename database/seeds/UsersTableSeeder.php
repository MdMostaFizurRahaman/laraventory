<?php

use App\Models\Client;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@annanovas.com')->get();

        if ($user->count() == 0) {
            $role = Role::where('client_id', Client::first()->id)->first();

            $user = User::updateOrCreate(
                [
                    'email' => 'admin@annanovas.com',
                ],
                [
                    'name' => 'AnnaNovas IT LTD',
                    'role_id' => $role->id,
                    'client_id' => Client::first()->id,
                    'email' => 'admin@annanovas.com',
                    'password' => bcrypt('111111'),
                    'status' => 1,
                ]
            );

            // Attached role to user
            if ($user->wasRecentlyCreated) {
                $user->attachRole($user->role_id);
            }
        }


        // $user = User::create([
        //     'name' => 'Ahmed Shakil',
        //     'client_id' => Client::first()->id,
        //     'email' => 'asgraphicsolution@gmail.com',
        //     'password' => bcrypt('mama@1234'),
        //     'status' => 1,
        // ]);
        // $role = Role::where('user_id', Client::first()->id)->first();
        // $user->attachRole($role->id);

    }
}
