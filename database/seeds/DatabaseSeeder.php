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

        // $this->call(UsersTableSeeder::class);
        $this->call(brandSeeder::class);
        $this->call(categorySeeder::class);
        $this->call(colorSeeder::class);
        $this->call(giftCardSeeder::class);
        $this->call(photoSeeder::class);
        $this->call(productSeeder::class);
        $this->call(addressSeeder::class);
        $this->call(orderSeeder::class);
        $this->call(commentSeeder::class);
    }
}
