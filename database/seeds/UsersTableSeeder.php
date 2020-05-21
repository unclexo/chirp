<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run() : void
    {
        factory(User::class)->create([
            'name'              => 'John Doe',
            'email'             => 'john@doe.com',
            'email_verified_at' => now(),
        ]);
    }
}
