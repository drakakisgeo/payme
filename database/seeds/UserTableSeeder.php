<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => getenv('USER_NAME'),
          'email' => getenv('USER_EMAIL'),
          'password' => Hash::make(getenv('USER_PASSWORD')),
        ]);
    }
}
