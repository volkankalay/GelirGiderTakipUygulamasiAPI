<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $currencies = [
        ['TRY', 'Türk Lirası'],
        ['USD', 'ABD Doları'],
        ['EUR', 'Euro'],
      ];
      foreach ($currencies as $currency) {
        DB::table('currencies')->insert([
          'code'=>$currency[0],
          'name'=>$currency[1]
        ]);
      }
    }
}
