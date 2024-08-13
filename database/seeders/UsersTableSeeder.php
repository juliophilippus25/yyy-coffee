<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::insert([
            [
              'id'  			=> 1,
              'name'  			=> 'Admin',
              'username'		=> 'yyycoffee',
              'password'		=> bcrypt('password'),
              'roles'            => 'Admin',
              'image'			=> NULL,
              'created_at'      => \Carbon\Carbon::now(),
              'updated_at'      => \Carbon\Carbon::now()
            ],
            [
                'id'  			=> 2,
                'name'  	    => 'Julio Philippus',
                'username'		=> 'julzybae',
                'password'		=> bcrypt('password'),
                'roles'          => 'Staff',
                'image'			=> NULL,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now()
            ]
        ]);
    }
}
