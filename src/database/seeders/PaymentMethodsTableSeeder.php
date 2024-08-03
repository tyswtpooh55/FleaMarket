<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            ['method' => 'クレジットカード払い'],
            ['method' => 'コンビニ払い'],
            ['method' => '銀行振込'],
        ]);
    }
}
