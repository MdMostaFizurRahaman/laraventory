<?php

use App\Models\Client;
use App\Role;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = Client::all();

        if ($client->count() == 0) {
            $client = Client::updateOrCreate(
                [
                    'email' => 'admin@annannovas.com',
                ],
                [
                    'name' => 'AnnaNovas IT LTD',
                    'address' => 'Ring Road, Mohammadpur',
                    'phone' => '01000000000',
                    'email' => 'admin@annannovas.com',
                    'client_website' => 'annanovas.com',
                    'client_url' => 'annanovas',
                    'contact_person_name' => 'Shahriar Rahman',
                    'contact_person_phone' => '01000000000',
                    'contact_person_email' => 'admin@annannovas.com',
                    'status' => 1
                ]
            );

            Role::updateOrCreate([
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => "Admin Role for " . $client->name . " Client",
                'client_id' => $client->id,
                'type' => 'client'
            ]);
        }





        // $client = Client::create([
        //     'name' => 'Ahmed Shakil',
        //     'address' => 'Ring Road, Mohammadpur',
        //     'phone' => '01834507645',
        //     'email' => 'asgraphicsolution@gmail.com',
        //     'client_website' => 'ahmedshakil.com',
        //     'client_url' => 'client',
        //     'contact_person_name' => 'Ahmed Shakil',
        //     'contact_person_phone' => '01533923971',
        //     'contact_person_email' => '999itsolution@gmail.com',
        //     'status' => 1
        // ]);


        // Role::create([
        //     'name' => 'admin',
        //     'display_name' => 'Admin',
        //     'description' => "Admin Role for " . $client->name . " Client",
        //     'user_id' => $client->id
        // ]);
    }
}
