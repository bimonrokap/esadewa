<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Super Admin',
            'username' => '12345',
            'password' => bcrypt('12345')
        ]);
    }
}
