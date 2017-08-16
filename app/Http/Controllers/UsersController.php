<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\User;
use Illuminate\Http\Request;
use App\PrivateMessage;

class UsersController extends Controller
{
    public function show($username)
    {
//        throw new \Exception('Simulando ');  This is only to simulate an exception
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

    public function sendPrivateMessage($username, Request $request)
    {
        $user = $this->findByUsername($username);
        $me = $request->user();
        $message = $request->input('message');

        $conversation = Conversation::between($me, $user);

        $privateMessage = PrivateMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $me->id,
            'message' => $message,
        ]);

        return redirect('/conversations/'.$conversation->id);
    }

    public function showConversation(Conversation $conversation)
    {
        $conversation->load('users', 'privateMessages');
        return view('users.conversation', [
            'conversation' => $conversation,
            'user' => auth()->user(),
         ]);
    }


    private function findByUsername($username)
    {
        return $user = User::where('username', $username)->firstOrFail();
    }


}
