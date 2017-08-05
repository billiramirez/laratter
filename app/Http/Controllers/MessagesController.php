<?php

namespace App\Http\Controllers;

use App\Message;
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

    public function create(Request $request)
    {
        dd($request->all());
        return 'Creado';
    }
}

