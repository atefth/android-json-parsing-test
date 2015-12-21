<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Atef Haque', 'email' => 'atefth@gmail.com', 'password' => 'password'],
            ['name' => 'Prima Tasnim', 'email' => 'prima@gmail.com', 'password' => 'password'],
            ['name' => 'Anwar Kabir', 'email' => 'anwar@gmail.com', 'password' => 'password'],
            ['name' => 'Ivy H. Russell', 'email' => 'ivy@gmail.com', 'password' => 'password']
        ];
        foreach ($users as $key => $user) {
            $name = $user['name'];
            $email = $user['email'];
            $password = $user['password'];
            $now = date('Y-m-d H:i:s');
            DB::insert(DB::raw("insert into users (name, email, password, created_at) values ('$name', '$email', '$password', '$now')"));
        }
    }
}
