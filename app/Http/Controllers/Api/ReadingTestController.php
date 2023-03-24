<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\ReadingTest;
use Illuminate\Http\Request;

class ReadingTestController extends Controller
{
    use ResponseTemplate;
    public function index(Request $request)
    {
        $tests = ReadingTest::with(['readings' => function ($query) {
            return $query->with(['questions' => function($query){
                return $query->with(['answers']);
            }])->orderBy('orderIndex');
        }])->orderBy('orderIndex', 'ASC')->get();
        $this->setData($tests);
        return $this->response();
    }
}
