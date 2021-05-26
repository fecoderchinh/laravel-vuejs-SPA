<?php

use Database\Seeders\TaskSeeder;
use Database\Seeders\UserRolePermissionSeeder;
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
//        $this->call(UserRolePermissionSeeder::class);
        $this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\UncategorizedSeeder::class);
        $this->call(TaskSeeder::class);
    }
}
