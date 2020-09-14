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
        DB::table('users')->insert([
            'name' => 'ぺったん太郎',
            'email' => 'p@petata.com',
            'password' => Hash::make('petapeta'),
        ]);
    }
}
