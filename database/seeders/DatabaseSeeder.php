<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DataSetSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DataSetSeeder::class);
        \App\Models\User::factory(25)->create();
        \App\Models\Product::factory(50)->create();
//        \App\Models\Purchase::factory(50)->create();
//        \App\Models\Order::factory(50)->create();

    }
}
