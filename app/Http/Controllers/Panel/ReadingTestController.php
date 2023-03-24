<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ReadingTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadingTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = ReadingTest::orderBy('orderIndex', 'ASC')->get();
        return view('readingTest.index', compact(['tests']));
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
        $latsIndex = ReadingTest::orderBy('orderIndex', 'DESC')->first()->orderIndex ?? 0;
        ReadingTest::create([
            'title' => $request->title,
            'orderIndex' => $latsIndex + 1
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $test = ReadingTest::with(['readings' => function($query){
            $query->with(['questions' => function($query){
                return $query->orderBy('orderIndex');
            }]);
        }])->find($id);
        return view('readingTest.edit',compact(['test']));
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
        ReadingTest::find($id)->update($request->all());
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
        $test = ReadingTest::find($id);
        $questions = $test->questions;
        foreach ($questions as $question) {
            $question->answers()->delete();
        }
        $test->questions()->delete();
        ReadingTest::where('orderIndex', '>', $test->orderIndex)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        $test->delete();
        return redirect()->back();
    }
}
