<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay($order_id)
    {
        $order = Order::find($order_id);
        $response = zarinpal()
        ->merchantId(env('ZARINPAL')) // تعیین مرچنت کد در حین اجرا - اختیاری
        ->amount($order->payable) // مبلغ تراکنش
        ->request()
        ->description('خرید اشتراک msc') // توضیحات تراکنش
        ->mobile($order->user->mobile)
        // ->email('hamidreza.behrad96@gmail.com')
        ->callbackUrl("http://app.mscenglish.ir/verifyPayment")
        ->send();
        
        if (!$response->success()) {
            return $response->error()->message();
        }
        
        $order->payments()->create([
            'amount' => $order->payable,
            'authority' => $response->authority()
        ]);

        // هدایت مشتری به درگاه پرداخت
        return $response->redirect();
    }

    public function verify(Request $request)
    {
        $authority = $request->Authority; // دریافت کوئری استرینگ ارسال شده توسط زرین پال 
        $status =  $request->Status; // دریافت کوئری استرینگ ارسال شده توسط زرین پال
        $payment = Payment::where('authority',$authority)->first();
        if(!$payment)
           abort(403);
        
        if($status=='OK')
        {
        $response = zarinpal()
        ->merchantId(env('ZARINPAL')) // تعیین مرچنت کد در حین اجرا - اختیاری
        ->amount($payment->order->payable)
        ->verification()
        ->authority($authority)
        ->send();
      
      
        
     if (!$response->success() && $response->error()->code() != 101) {
        $payment->status_code = $response->error()->code();
        $payment->status = 'FAILED';
        $payment->save();
         $error = $response->error()->message();
         return view('failed-pay',compact('error'));
    }
    else
    {
        $payment->status_code = 101;
        $payment->status = 'PAID';
        if($response->success()){
            $payment->card_number = $response->cardPan();
        $payment->card_number_hash = $response->cardHash();
        $payment->reference_id = $response->referenceId();
        $payment->fee_type = $response->feeType();
        $payment->fee = $response->fee()/ 10;
        $payment->status_code = 100;
        }
        
        
        $payment->order()->update([
            'status' => 'PAID'
        ]);
        $payment->order->user()->update([
            'payStatus' => 1
        ]);
        $payment->save();
        return view('success-pay');
    }
        }
        else
        {
            $payment->status = 'FAILED';
            $payment->save();
            $error = "پرداخت نا موفق";
            return view('failed-pay',compact('error'));
        }
    }
}
