<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('created_at','DESC')->get();
        return view('message.index',compact(['messages']));
    }

    public function store(Request $request)
    {
        Message::create([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->back();
    }

    public function update(Request $request,$id)
    {
        Message::find($id)->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Message::find($id)->delete();
        return redirect()->back();
    }
}
