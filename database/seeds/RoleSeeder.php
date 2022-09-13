<?php

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'SUPERADMIN',
            ],
            [
                'name' => 'ADMIN',
            ]
        ];

        foreach ($data as $value) {
            Role::create($value);
        }
    }
}
