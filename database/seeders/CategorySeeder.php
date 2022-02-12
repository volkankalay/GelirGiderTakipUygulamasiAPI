<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach (range(0,20) as $category) {
        DB::table('categories')->insert([
          'is_income'=>rand(0,1),
          'name'=>Str::upper(Str::random(4).' '.Str::random(3)),
          'user_id'=>1
        ]);
      }
    }
}
