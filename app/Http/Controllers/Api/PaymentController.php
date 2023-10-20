<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        ->callbackUrl("http://mscenglish.ir/api/verifyPeyment/$order_id")
        ->send();
        //  dd($response);
        if (!$response->success()) {
            return $response->error()->message();
        }
        // dd($response->authority());
        // ذخیره اطلاعات در دیتابیس
        // $response->authority();

        // هدایت مشتری به درگاه پرداخت
        return $response->redirect();
    }
}
