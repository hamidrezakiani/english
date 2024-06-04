<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTemplate;
    public function purchases(Request $request)
    {
         $request->validate([
          'service' => 'required|exists:services,type'
         ]);
         $service_type = $request->service;
         $service = Service::where('type',$service_type)->first();
         $order = Order::where('service_id',$service->id)
                  ->where('user_id',auth('api')->user()->id)
                  ->where('status','NOT_PAID')
                  ->first();
         if(!$order)
           $order = Order::create([
              'user_id' => auth('api')->user()->id,
              'service_id' => $service->id,
              'payable' => $service->amount
           ]);
         $this->setData(['amount' => $order->payable,"discount" => $service->amount - $order->payable,'order_id' => $order->id]); 
         return $this->response();
    }
    public function setDiscount(Request $request)
    {
         $request->validate([
          'service' => 'required|exists:services,type'
         ]);
         $service_type = $request->service;
         $discount = $request->discount;
         $discount = Discount::where('code',$discount)->first();
         $service = Service::where('type',$service_type)->first();
         $order = Order::where('service_id',$service->id)
                  ->where('user_id',auth('api')->user()->id)
                  ->where('status','NOT_PAID')
                  ->first();
         
          if($order)
          {
              if(!$order->discount_id)
              {
                  if($discount)
                  {
                      $order->payable = $service->amount - $discount->amount;
                      if($order->payable < 0)
                        $order->payable = 0;
                      $order->discount_id = $discount->id;
                      $order->save();
                      $this->setData(['amount' => $order->payable,'order_id' => $order->id]); 
                  }
                  else
                  {
                    $this->setErrors([
                      'message' => ['کد وارد وارد شده معتبر نیست'],
                    ]);
                  $this->setStatus(422);
                  }
              }
              else
              {
                $this->setErrors([
                  'message' => ['شما قبلا از کد تخفیف استفاده کرده اید'],
                ]);
                 $this->setStatus(422);
              }
          }
          else
          {
             $this->setErrors([
                 'message' => ['لطفا سرویس مورد نظر را انتخاب کنید.'],
             ]);
             $this->setStatus(403);
          }
          
         
         return $this->response();
    }
}
