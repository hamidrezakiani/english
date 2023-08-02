<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTemplate;
    public function getAmount(Request $request)
    {
         $service_name = $request->service_name;
         $service = Service::where('type','SUBSCRIPTION')->first();
         $this->setData(['amount' => $service->amount]);
         return $this->response();
    }
}
