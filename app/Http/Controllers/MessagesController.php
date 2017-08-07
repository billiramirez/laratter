<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{

//    If we receive an object as a parameter, we can validate if the id wouldn't exist, it means an error 404
    public function show(Message $message)
    {
        //Find the message by id
//        $message = Message::find($id);

        return view('messages.show',[
            'message' => $message,
        ]);
    }

    public function create(CreateMessageRequest $request)
    {

//        Adding the array plus into the validation we can costume our feedback messages when they are displayed in the form

        $user = $request->user();

        $message = Message::create([
              'user_id' => $user->id,
              'content' => $request->input('message'),
              'image' => 'http://lorempixel.com/600/338?'.mt_rand(0, 1000)
          ]);

        return redirect('/messages/'.$message->id);
    }
}

