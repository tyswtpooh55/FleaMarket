<?php

namespace Database\Seeders;

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
        $this->call([
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            MasterDatabaseSeeder::class,
            RelatedItemsTableSeeder::class,
            LikesTableSeeder::class,
            CommentsTableSeeder::class,
            TransactionsTableSeeder::class,
        ]);
    }
}
