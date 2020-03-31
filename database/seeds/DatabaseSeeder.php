<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(MaterialCategoryTableSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(MaterialTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(AccountTableSeeder::class);
        $this->call(CostTypeTableSeeder::class);
        $this->call(ProductTableSeeder::class);

    }
}
