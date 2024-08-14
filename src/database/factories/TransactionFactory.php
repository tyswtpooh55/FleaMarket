<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //1itemにつき、取引は１回
        static $usedItemId = [];

        $item = Item::whereNotIn('id', $usedItemId)
            ->inRandomOrder()
            ->first();

        //出品者と購入者は重複しない
        $buyer = User::withoutRole('admin')
            ->where('id', '!=', $item->seller_id)
            ->inRandomOrder()
            ->first();

        $usedItemId[] = $item->id;

        return [
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'method_id' => PaymentMethod::inRandomOrder()
                ->first()
                ->id,
        ];
    }
}
