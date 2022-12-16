<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function store(Request $request)
    {
        $lastQuestionIndex = Question::where('test_id',$request->test_id)->count();
        $question = Question::create([
            'test_id' =>  $request->test_id,
            'question' => $request->question,
            'orderIndex' => $lastQuestionIndex+1
        ]);

        foreach($request->answer as $key => $answer)
        {
            $status = $key == $request->trueAnswer;
            $question->answers()->create([
                'text' => $answer,
                'status' => $status
            ]);
        }

        return redirect()->back();
    }

    public function update($id,Request $request)
    {
        Question::find($id)->update([
            'orderIndex' => $request->index,
            'question' => $request->question
        ]);

        foreach($request->answer as $answer)
        {
            $status = $request->trueAnswer == $answer['id'];
            Answer::find($answer['id'])->update([
                'text' => $answer['text'],
                'status' => $status
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $question->answers()->delete();
        Question::where('orderIndex','>',$question->orderIndex)->where('test_id',$question->test_id)->update(['orderIndex' => DB::raw('orderIndex - 1')]);
        $question->delete();
        return redirect()->back();
    }
}
