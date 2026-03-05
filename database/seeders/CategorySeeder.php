<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =
            [
                ['category_type_id' => 1, 'category_name' => 'profile', 'display_name' => '','category_code'=> 1 ,'sorting_order' => 1],
                ['category_type_id' => 1, 'category_name' => 'user', 'display_name' => '','category_code'=> 2 ,'sorting_order' => 2],
                ['category_type_id' => 1, 'category_name' => 'role', 'display_name' => '','category_code'=> 3 ,'sorting_order' => 3],
                ['category_type_id' => 1, 'category_name' => 'permission', 'display_name' => '','category_code'=> 4 ,'sorting_order' => 4],
                ['category_type_id' => 1, 'category_name' => 'setup', 'display_name' => '','category_code'=> 5 ,'sorting_order' => 5],
                ['category_type_id' => 1, 'category_name' => 'setting', 'display_name' => '','category_code'=> 6 ,'sorting_order' => 6],

            ];

            foreach($datas as $data){
                DB::table('categories')->insert($data);
            }
    }
}
