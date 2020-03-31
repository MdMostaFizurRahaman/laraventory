<?php

use App\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = DB::table('currencies')->get();

        if ($currencies->count() == 0) {
            factory(Currency::class, 10)->create();
        }
    }
}
