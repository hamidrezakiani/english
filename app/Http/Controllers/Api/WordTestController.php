<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\WordTest;
use Illuminate\Http\Request;

class WordTestController extends Controller
{
    use ResponseTemplate;

    public function index(Request $request)
    {
        $tests = WordTest::with(['questions'])->orderBy('orderIndex', 'ASC')->get();
        $this->setData($tests);
        return $this->response();
    }
}
