<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;     
use Illuminate\Support\Facades\Hash;   
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         {
             DB::table('users')->insert([
                 [
                     'name' => 'admin',
                     'email' => 'admin@example.com',
                     'password' => Hash::make('password'), 
                     'role_as' => 'admin',
                     'created_at' => now(),
                     'updated_at' => now(),
                 ],
                 [
                     'name' => 'kasir',
                     'email' => 'kasir@example.com',
                     'password' => Hash::make('password'), 
                     'role_as' => 'kasir',
                     'created_at' => now(),
                     'updated_at' => now(),
                 ]
             ]);
         }
     }
}