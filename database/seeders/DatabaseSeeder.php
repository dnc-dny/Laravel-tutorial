<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TodoListSeeder::class
        ]);

         // ユーザーを3人追加
        User::factory()->count(3)->create();
    }
}
