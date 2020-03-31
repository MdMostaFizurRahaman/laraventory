<?php

use App\Models\CostType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CostTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costTypes = DB::table('cost_types')->get();
        
        if ($costTypes->count() == 0) {
            factory(CostType::class, 10)->create();
        }


        // factory(CostType::class, 10)->create();
    }
}
