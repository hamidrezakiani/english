<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Other;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function wordTestHelp()
    {
        $value = Other::where('key','WordTestHelp')->first();
        return view('other.wordTestHelp',compact(['value']));
    }

    public function updateWordTestHelp(Request $request)
    {
        $value = Other::where('key','WordTestHelp')->first();
        $value->update([
            'value' => $request->text
        ]);
        return redirect()->back();
    }

    public function readingTestHelp()
    {
        $value = Other::where('key', 'ReadingTestHelp')->first();
        return view('other.readingTestHelp', compact(['value']));
    }

    public function updateReadingTestHelp(Request $request)
    {
        $value = Other::where('key', 'ReadingTestHelp')->first();
        $value->update([
            'value' => $request->text
        ]);
        return redirect()->back();
    }

    public function planning()
    {
        $value = Other::where('key','Planning')->first();
        return view('other.planning',compact(['value']));
    }

    public function updatePlanning(Request $request)
    {
        $value = Other::where('key', 'Planning')->first();
        $value->value = $request->text;
        return view('other.planning', compact(['value']));
    }
}
