<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;

class RelatedItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()
            ->count(50)
            ->has(ItemImage::factory()->count(3), 'itemImages')
            ->create();

        $items = Item::all();
        $categories = Category::all();

        foreach ($items as $item) {
            $item->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );
        }
    }
}
