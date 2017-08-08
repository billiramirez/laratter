<?php

namespace App\Http\Controllers;

use App\SocialProfile;
use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('facebook')->user();

        session()->flash('FacebookUser',$user);

        return view('users.facebook', [
           'user' => $user,
        ]);
    }
    public function register(Request $request)
    {
        $data = session('FacebookUser');

        $username = $request->input('username');

        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'avatar' => $data->avatar,
            'username' => $username,
            'password' => str_random(16),
        ]);

        $profile = SocialProfile::create([
            'social_id' => $data->id,
            'user_id' => $user->id,
        ]);

        auth()->login($user);
        return redirect('/');
    }


}
