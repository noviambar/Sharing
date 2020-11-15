<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name'=>'Administrator',
        'email'=>'aserver348@gmail.com',
        'password'=>bcrypt('Ambarwati11'),
        'role' => 'admin',]);
    }
}
