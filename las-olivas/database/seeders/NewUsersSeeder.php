<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class NewUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::insert([
            'name' => 'Sandra',
            'email' => 'sandraferraro@gmail.com',
            'password' => bcrypt('defaultpassword')
        ]);

        User::insert([
            'name' => 'Lucrecia',
            'email' => 'lasolivaspringles@gmail.com',
            'password' => bcrypt('defaultpassword')
        ]);
        
    }
}