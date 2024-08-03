<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Customer1',
            'email' => 'customer1@example.com',
            'password' => bcrypt('pass1234'),
            'img_url' => 'images/dummyImages/bat.png'
        ]);

        User::factory()
            ->count(10)
            ->create();
    }
}
