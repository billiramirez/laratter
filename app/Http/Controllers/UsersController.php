<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($username)
    {
        $user = $this->findByUsername($username);

        return view('users.show', [
                    'user' => $user,
        ]);
    }

    /** This method is made for follow a user**/
    public function follow($username, Request $request)
    {
        $user = $this->findByUsername($username);/** Searching the user we clicked **/
        $me = $request->user(); /** The request in order to know who is logged**/

        $me->follows()->attach($user); /** attach the clicked user to the current user**/

         return redirect('/'.$username)->withSuccess('Usuario Seguido');

    }

    /** This method is made for unfollow a user**/
    public function unfollow($username, Request $request)
    {
        $user = $this->findByUsername($username);/** Searching the user we clicked **/
        $me = $request->user(); /** The request in order to know who is logged**/

        $me->follows()->detach($user); /** detach the clicked user to the current user**/

        return redirect('/'.$username)->withSuccess('Usuario No Seguido');

    }

    /** This method is made for showing the a user follow**/
    public function follows($username)
    {
        $user = $this->findByUsername($username);

        return view('users.follows',[
            'user' => $user,
            'follows' => $user->follows,
        ]);
    }

    public function followers($username)
    {
        $user = $this->findByUsername($username);

        return view('users.follows',[
            'user' => $user,
            'follows' => $user->followers,
        ]);
    }

    private function findByUsername($username)
    {
        return $user = User::where('username', $username)->first();
    }


}
