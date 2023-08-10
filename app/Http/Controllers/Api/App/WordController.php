<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WordController extends Controller
{
    use ResponseTemplate;
    private $lastUpdatedAt;
    private $currentUpdatingAt;
    public function index(Request $request)
    {
         $this->lastUpdatedAt = $request->lastUpdatedAt;
         $this->currentUpdatingAt = $request->currentUpdatingAt;
         if(!$this->currentUpdatingAt)
         {
            $this->currentUpdatingAt = Carbon::now();
         }
         if($this->lastUpdatedAt)
           $words = $this->withoutDeleted();
         else
           $words = $this->withDeleted();
        
        $this->setData(['words' => $words,'currentUpdatingAt' => $this->currentUpdatingAt]);
        return $this->response();
    }


    private function withoutDeleted()
    {
        dd($this->currentUpdatingAt);
        return Word::where('updated_at','<',$this->currentUpdatingAt)->paginate(100);
    }

    private function withDeleted()
    {
        dd($this->lastUpdatedAt);
        return Word::where('updated_at','>',$this->lastUpdatedAt)
        ->where('updated_at','<',$this->currentUpdatingAt)->withTrashed()->paginate(100);
    }

}
