<?php

use App\Traits\MyUuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsTableSeeder extends Seeder
{

    use MyUuid;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalRecords = 10;
        $data = [];

        for ($i = 1; $i <= $totalRecords; $i++) {
            $data[] = [
                'uuid' => $this->generateUuid(),
                'name' => 'Asset #' . $i,
                'asset_category_id' => rand(1, 5),
                'user_id' => rand(1, 5),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('assets')->insert($data);
    }
}
