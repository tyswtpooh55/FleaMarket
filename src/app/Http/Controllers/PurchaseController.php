<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);
        $user = Auth::user();

        session(['item_id' => $id]);

        return view('purchase', compact(
            'item',
            'user',
        ));
    }

    public function address()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)
            ->first();

        return view('purchase_address', compact(
            'profile',
        ));
    }

    public function updateAddress(ProfileRequest $request)
    {
        $user= Auth::user();

        $postcode = $request->input('postcode');
        if (!strpos($postcode, '-')) {
            $postcode = preg_replace('/(\d{3})(\d{4})/', '$1-$2', $postcode);
        }

        if ($user->profile) {
            $profile = $user->profile->first();

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

        $itemId = session('item_id');
        return redirect()->route('purchase', ['item_id' => $itemId]);
    }
}
