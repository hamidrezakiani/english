<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTemplate;
    public function purchases(Request $request)
    {
         $service_type = $request->service;
         $service = Service::where('type',$service_type)->first();
         $order = Order::where('service_id',$service->id)->where('user_id',auth('api')->user()->id)->first();
         if(!$order)
           $order = Order::create([
              'user_id' => auth('api')->user()->id,
              'service_id' => $service->id,
              'payable' => $service->amount
           ]);
         $this->setData(['amount' => $service->amount,'order_id' => $order->id]);
         return $this->response();
    }
}
