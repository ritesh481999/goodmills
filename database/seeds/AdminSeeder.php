<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@goodmills.com',
                'password' => Hash::make('123456'),
                'role_id' => 1,
                'selected_country_id' => 1
            ]
        ];

        foreach ($users as $user) $this->makeUser($user);
    }

    private function makeUser($user)
    {
        User::updateOrCreate([
            'email' => $user['email']
        ], $user);
    }
}
