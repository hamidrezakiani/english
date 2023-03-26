<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ResponseTemplate;
    public function index()
    {
        $messages = Message::orderBy('created_at', 'DESC')->get(['id','title','text','deleted_at']);
        $this->setData($messages);
        return $this->response();
    }
}
