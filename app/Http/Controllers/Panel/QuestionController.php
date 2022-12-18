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
        $question = Question::find($id);
        $question->update([
            'orderIndex' => $request->orderIndex ?? $question->orderIndex,
            'question'   => $request->question ?? $question->question,
            'translate'  => $request->translate ?? $question->translate,
            'solve'      => $request->solve ?? $question->solve,
        ]);

        foreach($request->answer as $answer)
        {
            if($request->trueAnswer)
              $status = $request->trueAnswer == $answer['id'];

            $row = Answer::find($answer['id']);
            $row->update([
                'text'      => $answer['text'] ?? $row->text,
                'translate' => $answer['translate'] ?? $row->translate,
                'status'    => $status ?? $row->status,
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
