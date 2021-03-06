<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class,5)->create();
        factory(\App\Models\Product::class,50)->create();
        factory(\App\Models\Review::class,300)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
