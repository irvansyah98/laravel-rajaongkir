<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $result = \DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => \Hash::make('password'),
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);
    }
}
