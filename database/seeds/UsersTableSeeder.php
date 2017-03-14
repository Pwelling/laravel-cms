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
            'name' => 'Patrick',
            'email' => 'patrick@wellingonline.eu',
            'password' => bcrypt('#R@pPote5!'),
        ]);
    }
}
