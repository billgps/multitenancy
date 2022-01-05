<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name' => 'Super User',
            'email' => 'super.user@gmail.com',
            'password' => bcrypt('password'),
            // 'role' => 0,
            'phone' => '-',
            'nip' => '-',
            'position' => 'admin',
            'group' => 'admin'
        ]);

        $user->assignRole('admin');
    }
}
