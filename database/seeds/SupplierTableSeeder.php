<?php

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $suppliers = DB::table('suppliers')->get();

        if ($suppliers->count() == 0) {
            Supplier::unsetEventDispatcher();
            factory(Supplier::class, 20)->create();
        }


        // Supplier::unsetEventDispatcher();
        // factory(Supplier::class, 50)->create();
    }
}
