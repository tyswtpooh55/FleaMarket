<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('mypage', compact(
            'user',
        ));
    }

    public function profile()
    {
        $user = Auth::user();

        $profile = $user->profile;

        return view('mypage_profile', compact(
            'user',
            'profile',
        ));
    }

    public function updateProfile(ProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $postcode = $request->input('postcode');
        if (!strpos($postcode, '-')) {
            $postcode = preg_replace('/(\d{3})(\d{4})/', '$1-$2', $postcode);
        }

        if ($user->profile) {
            $profile = $user->profile;

            $user->name = $request->input('name');
            $user->save();

            $profile->postcode = $postcode;
            $profile->address = $request->input('address');
            $profile->building = $request->input('building');

            if ($request->hasFile('imgUrl')) {
                if ($profile->img_url) {
                    Storage::delete($profile->img_url);
                }
                $path = $request->file('imgUrl')
                    ->store('public/images/profile');
                $user->img_url = str_replace('public', '', $path);
            }

            $profile->save();

        } else {
            $user->name = $request->input('name');
            $user->save();

            $path = null;
            if ($request->hasFile('imgUrl')) {
                $path = $request->file('imgUrl')
                    ->store('public/images/profile');
                $user->img_url = str_replace('public', '', $path);
            }

            Profile::create([
                'user_id' => $user->id,
                'postcode' => $postcode,
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]);
        }

        return redirect()->route('mypage.index');
    }
}
