<?php

use App\Admin;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Eslam Gamal',
            'email' => 'eslamgamal95@gmail.com',
            'password' => bcrypt(123456789)
        ]);
    }
}
