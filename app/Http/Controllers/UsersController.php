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

    public function follow($username, Request $request)
    {
        $user = $this->findByUsername($username);/** Searching the user we clicked **/
        $me = $request->user(); /** The request in order to know who is logged**/

        $me->follows()->attach($user); /** attach the clicked user to the current user**/

         return redirect('/'.$username)->withSuccess('Usuario Seguido');

    }

    public function follows($username)
    {
        $user = $this->findByUsername($username);

        return view('users.follows',[
            'user' => $user
        ]);
    }

    private function findByUsername($username)
    {
        return $user = User::where('username', $username)->first();
    }


}
