<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'name'=>'User1',
        'email'=>'test@demo.com',
        'password'=>bcrypt(123456),
        'created_at'=>now(),
        'updated_at'=>now()
      ]);
    }
}
