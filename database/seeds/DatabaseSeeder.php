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
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        $this->call(userSeeder::class);
        $this->call(brandSeeder::class);
        $this->call(tagSeeder::class);
        $this->call(categorySeeder::class);
        $this->call(colorSeeder::class);
        $this->call(giftCardSeeder::class);
        $this->call(photoSeeder::class);
        $this->call(productSeeder::class);

        $this->call(addressSeeder::class);
        $this->call(orderSeeder::class);
        $this->call(commentSeeder::class);
        $this->call(ratingSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(roleSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(settingSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(attributeSeeder::class);
        $this->call(attributeValueSeeder::class);
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
