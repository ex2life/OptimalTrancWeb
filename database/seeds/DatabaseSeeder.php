<?php

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
        // Role comes before User seeder here.
        $this->call(RoleTableSeeder::class);
        // Mobile seeder.
        $this->call(MobileTableSeeder::class);
        // Avatar seeder.
        $this->call(AvatarTableSeeder::class);
        // User seeder will use the roles above created.
        $this->call(UserTableSeeder::class);
        // City seeder.
        $this->call(CityTableSeeder::class);

    }
}
