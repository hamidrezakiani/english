<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class ImportWordTest extends Controller
{
    public function import($id,Request $request)
    {
        // $file = file_get_contents(public_path('test.txt'));
        $request->validate([
            'file' => 'required|mimes:txt'
        ]);
        $file=$request->file('file');
        $file=\File::get($file->getRealPath());
        $file = trim($file);
        Question::where('type','WORD_TEST')->where('foreign_id',$id)->delete();
    \DB::beginTransaction();

       $questions = explode('#',$file);
       unset($questions[0]);
       $questions = array_values($questions);
       foreach($questions as $key1 => $q){
          $q = explode('@',$q);
          $q_text = $q[0];
          $questionModel = Question::create([
             'type' => 'WORD_TEST',
             'foreign_id' => $id,
             'question'   => $q_text,
             'orderIndex' => $key1 + 1
          ]);
          $answers = explode(PHP_EOL,$q[1]);
          $b = [];
          foreach($answers as $key2 => $a){
            if(strtr($a,["\r" => '',' ' => '']) == "")
               unset($answers[$key2]);
            else
               $answers[$key2] = trim($a);

          }
          $answers = array_values($answers);
          $orderAndswers = [];
          foreach ($answers as $key3 => $a) {
             $char = substr($a,0,1);
             if($char == 'a' || $char == 'b' || $char == 'c' || $char == 'd'){
               switch($char){
                  case 'a':
                     $index = 0;
                     break;
                  case 'b': 
                     $index = 1;
                     break;
                  case 'c':
                     $index = 2;
                     break;
                  case 'd':
                     $index = 3;   
               }
                 $a = trim(substr($a,1,strlen($a)-1));
             }else{
                \DB::rollBack();
               throw new \Exception("Answer order Error Question ".($key1+1), 1);
             }
             $char = substr($a,0,1);
             if($char == ')' || $char == '(' || $char == ')' || $char == '('){
                 $a = trim(substr($a,1,strlen($a)-1));
             }
             $answers[$key3] = $a;
             $orderAndswers[$index] = $a;
          }
          if(sizeof($answers) != 4 || sizeof($orderAndswers) != 4){
              \DB::rollBack();
              throw new \Exception("Error Question ".($key1+1), 1);
          }
          for ($i=0; $i < 4; $i++) { 
            $questionModel->answers()->create([
               'text' => $orderAndswers[$i],
               'status' => 0
             ]);
          }
       }
    \DB::commit();
    return redirect()->back();
    }

    public function importTr($id,Request $request)
    {
        // $file = file_get_contents(public_path('test.txt'));
        $request->validate([
            'file' => 'required|mimes:txt'
        ]);
        $file=$request->file('file');
        $file=\File::get($file->getRealPath());
        $file = trim($file);
    \DB::beginTransaction();
       $modelQuestions = Question::where('foreign_id',$id)->where('type','WORD_TEST')->get();
       $questions = explode('#',$file);
       unset($questions[0]);
       $questions = array_values($questions);
       foreach($questions as $key1 => $q){
          $q = explode('@',$q);
          $q_text = $q[0];
           $modelQuestions[$key1]->update([
             'translate'   => $q_text
          ]);
          $answers = explode(PHP_EOL,$q[1]);
          $b = [];
          foreach($answers as $key2 => $a){
            if(strtr($a,["\r" => '',' ' => '']) == "")
               unset($answers[$key2]);
            else
               $answers[$key2] = trim($a);

          }
          $answers = array_values($answers);
          $orderAndswers = [];
          foreach ($answers as $key3 => $a) {
             $char = mb_substr($a,0,1);
             
             if($char == 'آ' || $char == 'ب' || $char == 'ج' || $char == 'د'){
               switch($char){
                  case 'آ':
                     $index = 0;
                     break;
                  case 'ب': 
                     $index = 1;
                     break;
                  case 'ج':
                     $index = 2;
                     break;
                  case 'د':
                     $index = 3;   
               }
                 $a = trim(mb_substr($a,1,mb_strlen($a)-1));
             }else{
                \DB::rollBack();
               throw new \Exception("Answer order Error Question ".($key1+1), 1);
             }
            
             $char = mb_substr($a,0,1);
             if($char == ')' || $char == '(' || $char == ')' || $char == '('){
                 $a = trim(mb_substr($a,1,mb_strlen($a)-1));
             }
             $answers[$key3] = $a;
             
             $orderAndswers[$index] = $a;
          }
          
          if(sizeof($answers) != 4 || sizeof($orderAndswers) != 4){
              \DB::rollBack();
              throw new \Exception("Error Question ".($key1+1), 1);
          }
          $modelAnswers = $modelQuestions[$key1]->answers;
          for ($i=0; $i < 4; $i++) { 
            $modelAnswers[$i]->update([
               'translate' => str_replace("*","",$orderAndswers[$i]),
               'status' => str_contains($orderAndswers[$i],"*")
             ]);
          }
       }
    \DB::commit();
    return redirect()->back();
    }
}
