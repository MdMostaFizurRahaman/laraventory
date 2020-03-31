<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = DB::table('products')->get();

        if ($products->count() == 0) {
            Product::unsetEventDispatcher();
            factory(Product::class, 10)->create();
        }


        // Product::unsetEventDispatcher();
        // factory(Product::class, 10)->create();
    }
}
