<?php

use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\DB;

class MaterialCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialCategories = DB::table('material_categories')->get();
        
        if ($materialCategories->count() == 0) {
            factory(MaterialCategory::class, 10)->create();
        }

        // factory(MaterialCategory::class, 10)->create();
    }
}
