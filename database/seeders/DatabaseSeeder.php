<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Ensar KURT',
            'email' => '37beykozlu37@gmail.com',
            'password' => '$2y$10$V0FiWOeB7I7zPj9UzO9IE.YijoVZtTy5BBVYqTov6YM0oHyzaAXwm',
        ]);
    }
}
