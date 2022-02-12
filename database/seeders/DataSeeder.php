<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach (range(1,20) as $category) {
        DB::table('data')->insert([
          'transaction_date'=>now()->addDays(rand(1,20)),
          'amount'=>rand(40, 210),
          'currency_id'=>rand(1,3),
          'category_id' => rand(1,19),
          'user_id' => 1,
          'description'=> 'Random Datas '. $category,
        ]);
      }
    }
}
