<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function store(Request $request)
    {
        Reading::create([
           'test_id' => $request->test_id,
           'text' => $request->text,
           'translate' => $request->translate,
           'orderIndex' => $request->orderIndex ?? (Reading::count() + 1)
        ]);
        return redirect()->back();
    }

    public function update(Request $request,$id){
        Reading::find($id)->update($request->all());
        return redirect()->back();
    }

    public function destroy($id){
        
    }
}
