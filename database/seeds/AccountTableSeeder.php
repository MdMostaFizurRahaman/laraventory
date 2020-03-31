<?php

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = DB::table('accounts')->get();

        if ($accounts->count() == 0) {
            Account::unsetEventDispatcher();
            factory(Account::class, 10)->create();
        }

        // Account::unsetEventDispatcher();
        // factory(Account::class, 10)->create();
    }
}
