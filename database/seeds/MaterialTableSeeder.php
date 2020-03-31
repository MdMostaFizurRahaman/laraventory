<?php

use App\User;
use App\Models\Unit;
use App\Models\Client;
use App\Models\Material;
use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\DB;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = DB::table('materials')->get();
        
        if ($materials->count() == 0) {
            factory(Material::class, 10)->create();
        }

        // Material::unsetEventDispatcher();
        // factory(Material::class, 10)->create();

    }
}
