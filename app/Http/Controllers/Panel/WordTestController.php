<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WordTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::wordTests()->orderBy('orderIndex','ASC')->get();
        return view('wordTest.index',compact(['tests']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latsIndex = Test::wordTests()->orderBy('orderIndex', 'DESC')->first()->orderIndex ?? 0;
        Test::create([
            'title' => $request->title,
            'type' => 'WORD',
            'orderIndex' => $latsIndex+1
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test = Test::with(['questions'])->find($id);
        return view('wordTest.edit',compact(['test']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Test::find($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::find($id);
        $questions = $test->questions;
        foreach($questions as $question)
        {
            $question->answers()->delete();
        }
        $test->questions()->delete();
        Test::wordTests()->where('orderIndex','>',$test->orderIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        $test->delete();
        return redirect()->back();
    }
}
