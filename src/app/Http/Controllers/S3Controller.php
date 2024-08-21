<?php

namespace App\Http\Controllers;

use App\Http\Livewire\ItemImg;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function updateProfile(ProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $postcode = $request->input('postcode');
        if (!strpos($postcode, '-')) {
            $postcode = preg_replace('/(\d{3})(\d{4})/', '$1-$2', $postcode);
        }

        if ($request->has('imgUrl')) {
            if ($user->img_url) {
                Storage::delete($user->img_url);
            }
            $path = $request->file('imgUrl')
                ->store('images/profile');
            $user->img_url = $path;
        }

        $user->name = $request->input('name');
        $user->save();

        //$user->profile有→データ更新、無→データ作成
        if ($user->profile) {
            $profile = $user->profile;

            $profile->postcode = $postcode;
            $profile->address = $request->input('address');
            $profile->building = $request->input('building');

            $profile->save();
        } else {
            Profile::create([
                'user_id' => $user->id,
                'postcode' => $postcode,
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]);
        }

        return redirect()->route('mypage.index');
    }

    public function sale(ItemRequest $request)
    {
        $user = Auth::user();

        $item = Item::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'seller_id' => $user->id,
            'condition_id' => $request->input('condition_id')
        ]);

        if ($request->hasFile('img_url')) {
            foreach ($request->file('img_url') as $img) {
                $path = $img->store('images/items');
                ItemImg::create([
                    'item_id' => $item->id,
                    'img_url' => $path,
                ]);
            }
        }
        // 中間テーブルcategory_itemへのデータ挿入
        DB::table('category_item')->insert([
            'item_id' => $item->id,
            'category_id' => $request->input('category_id_1'),
        ]);
        if ($request->input('category_id_2')) {
            DB::table('category_item')->insert([
                'item_id' => $item->id,
                'category_id' => $request->input('category_id_2'),
            ]);
        }

        return redirect()->route('index');
    }
}
