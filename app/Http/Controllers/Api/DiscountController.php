<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    use ResponseTemplate;
    public function checkCode(Request $request)
    {
        $code = Discount::where('code',$request->code)->first();
        if($code)
        {
            $this->setData(['amount' => intval($code->amount),'code' => $code->code]);
        }
        else
        {
            $this->setErrors(['code' => ['کد تخفیف معتبر نیست']]);
            $this->setStatus(422);
        }

        return $this->response();
    }
}
