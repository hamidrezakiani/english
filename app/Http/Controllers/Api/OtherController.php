<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Other;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    use ResponseTemplate;
    public function planning()
    {
        $planning = Other::where('key','Planning')->first()->value;
        $this->setData($planning);
        return $this->response();
    }

    public function wordTestTutorial()
    {
        $tutorial = Other::where('key','WordTestHelp')->first()->value;
        $this->setData($tutorial);
        return $this->response();
    }
    public function readingTestTutorial()
    {
        $tutorial = Other::where('key', 'ReadingTestHelp')->first()->value;
        $this->setData($tutorial);
        return $this->response();
    }
}
