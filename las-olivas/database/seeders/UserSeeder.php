<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::insert([
            'name' => 'admin',
            'email' => 'testingautomat1234@gmail.com',
            'password' => bcrypt('las_olivas_admin')
        ]);
        
    }
}
