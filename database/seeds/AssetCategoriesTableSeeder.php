<?php

use Illuminate\Database\Seeder;

class AssetCategoriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\AssetCategory::class, 5)->create();
    }
}
