<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Grammar;
use Illuminate\Http\Request;

class GrammarController extends Controller
{
   use ResponseTemplate;

   public function index()
   {
       $grammars = Grammar::withTrashed()->get();
       $grammars->map(function($row){
          $row->deleted_at ? $row->text = $row->title = '' : null;
          return $row;
       });
       $this->setData($grammars);
       return $this->response();
   }
}
