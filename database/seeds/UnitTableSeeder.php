<?php

use App\Models\Client;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $units = Unit::all();

        if ($units->count() == 0) {
            Unit::updateOrCreate(
                [
                    'name' => 'kg'
                ],
                [
                    'name' => 'kg',
                    'display_name' => 'Kilogram',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'pcs'
                ],
                [
                    'name' => 'pcs',
                    'display_name' => 'pcs',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'roll'
                ],
                [
                    'name' => 'roll',
                    'display_name' => 'Roll',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'yard'
                ],
                [
                    'name' => 'yard',
                    'display_name' => 'Yard',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'inch'
                ],
                [
                    'name' => 'inch',
                    'display_name' => 'Inch',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'm'
                ],
                [
                    'name' => 'm',
                    'display_name' => 'Meter',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
            Unit::updateOrCreate(
                [
                    'name' => 'cm'
                ],
                [
                    'name' => 'cm',
                    'display_name' => 'Centimeter',
                    'description' => 'This is a description',
                    'client_id' => Client::first()->id
                ]
            );
        }


        // Unit::create(['name' => 'kg', 'display_name' => 'Kilogram', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'pcs', 'display_name' => 'pcs', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'roll', 'display_name' => 'Roll', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'yard', 'display_name' => 'Yard', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'inch', 'display_name' => 'Inchi', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'm', 'display_name' => 'Meter', 'description' => 'This is a description', 'client_id' => Client::first()->id ]);
        // Unit::create(['name' => 'cm', 'display_name' => 'Centimeter', 'description' => 'This is a description', 'client_id' => Client::first()->id]);
    }
}
