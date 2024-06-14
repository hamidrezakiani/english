<?php

namespace App\Http\Controllers\Panel;
use App\Models\Question;
use App\Models\Reading;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportReadingTest extends Controller
{
    public function import($id,Request $request)
    {
        // $file = file_get_contents(public_path('test.txt'));
        $request->validate([
            'file' => 'required|mimes:txt'
        ]);
        $file=$request->file('file');
        $file=\File::get($file->getRealPath());
        Reading::where('test_id',$id)->delete();
    \DB::beginTransaction();
    $readingsSection = explode('^',$file);
    unset($readingsSection[0]);
    $readingsSection = array_values($readingsSection);
    foreach($readingsSection as $key => $rs){
       $rs = explode('&',$rs);
       $reading = $rs[0];
       $readingModel = Reading::create([
         'test_id' => $id,
         'text' => $reading,
         'orderIndex' => $key + 1
       ]);
       $questions = explode('#',$rs[1]);
       unset($questions[0]);
       $questions = array_values($questions);
       foreach($questions as $key1 => $q){
          $q = explode('@',$q);
          $q_text = $q[0];
          $questionModel = Question::create([
             'type' => 'READING_TEST',
             'foreign_id' => $readingModel->id,
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
               throw new \Exception("Answer order Error Reading ".($key+1)." Question ".($key1+1), 1);
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
              throw new \Exception("Error Reading ".($key+1)." Question ".($key1+1), 1);
          }
          for ($i=0; $i < 4; $i++) { 
            $questionModel->answers()->create([
               'text' => $orderAndswers[$i],
               'status' => 0
             ]);
          }
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
    \DB::beginTransaction();
    $readingsSection = explode('^',$file);
    $readings = Reading::where('test_id',$id)->get();
    foreach($readingsSection as $key => $rs){
       $rs = explode('&',$rs);
       $reading = $rs[0];
       $readings[$key]->update([
         'translate' => $reading
       ]);
       $questions = $readings[$key]->questions;
       $questionsSection = explode('#',$rs[1]);
       foreach($questionsSection as $key1 => $q){
          $q = explode('@',$q);
          $q_text = $q[0];
          $question = $questions[$key1];
        
          $question->update([
            'translate' => $q_text
          ]);
          $answers = explode(PHP_EOL,$q[1]);
        
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
               throw new \Exception("Answer order Error Reading ".($key+1)." Question ".($key1+1), 1);
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
              throw new \Exception("Error Reading ".($key+1)." Question ".($key1+1), 1);
          }
          $questionAnswers = $question->answers;
          for ($i=0; $i < 4; $i++) { 
            $questionAnswers[$i]->update([
               'translate' =>  str_replace("*","",$orderAndswers[$i]),
               'status' => str_contains($orderAndswers[$i],"*")
            ]);
          }
       }
    }
    \DB::commit();
    return redirect()->back();
    }
}
