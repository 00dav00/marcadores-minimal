<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => 'admin@dataprensa.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
