<?php

namespace Database\Seeders;

use carbon\carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_type = [
            [
                "name" => "Fruits",
                "created_at" => Carbon::now(),
            ], [
                "name" => "Vegetables",
                "created_at" => Carbon::now(),
            ], [
                "name" => "Sweet",
                "created_at" => Carbon::now(),
            ], [
                "name" => "Juice",
                "created_at" => Carbon::now(),
            ],[
                "name" => "Milk-product",
                "created_at" => Carbon::now(),
            ],
        ];
        DB::table("categories")->insert($category_type);
    }
}