<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCategories = DB::table('product_categories')->get();

        if ($productCategories->count() == 0) {
            factory(ProductCategory::class, 10)->create();
        }

        // factory(ProductCategory::class, 10)->create();
    }
}
