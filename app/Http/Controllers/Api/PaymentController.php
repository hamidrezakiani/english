<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay()
    {
        $response = zarinpal()
        ->merchantId('00000000-0000-0000-0000-000000000000') // تعیین مرچنت کد در حین اجرا - اختیاری
        ->amount(500000) // مبلغ تراکنش
        ->request()
        ->description('transaction info') // توضیحات تراکنش
        ->mobile('09369422072')
        ->email('hamidreza.behrad96@gmail.com')
        ->callbackUrl('http://mscenglish.ir/api/verifyPeyment')
        ->send();
         dd($response);
        if (!$response->success()) {
            return $response->error()->message();
        }
        dd($response->authority());
        // ذخیره اطلاعات در دیتابیس
        // $response->authority();

        // هدایت مشتری به درگاه پرداخت
        return $response->redirect();
    }
}
