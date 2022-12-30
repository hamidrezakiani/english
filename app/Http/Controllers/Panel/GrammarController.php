<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Grammar;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
    public function index()
    {
        $grammars = Grammar::all();
        return view('grammar.index',compact(['grammars']));
    }

    public function store(Request $request)
    {
        Grammar::create([
            'title' => $request->title,
            'text'  => $request->text
        ]);
        return redirect()->back();
    }

    public function update($id,Request $request)
    {
        $grammar  = Grammar::find($id);
        $grammar->update([
            'title' => $request->title ?? $grammar->title,
            'text'  => $request->text ?? $grammar->text,
            'free'  => $request->free ?? $grammar->free
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        Grammar::find($id)->delete();
        return redirect()->back();
    }
}
