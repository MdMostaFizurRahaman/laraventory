<?php

use App\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = DB::table('banks')->get();

        if ($banks->count() == 0) {
            factory(Bank::class, 10)->create();
        }
        // Bank::unsetEventDispatcher();
        // factory(Bank::class, 10)->create();
    }
}
