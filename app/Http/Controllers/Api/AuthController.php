<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\SmsVerification;
use App\Models\User;
use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cryptommer\Smsir\Smsir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Service;
class AuthController extends Controller
{
    use ResponseTemplate;
    public function verificationCode(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();
        if(!$user)
          $user = User::create([
            'mobile' => $request->mobile,
            'ip'     => $request->ip(),
          ]);
        $code = rand(1000, 9999);
        $user->smsVerifications()->create([
            'code' => $code,
        ]);
        $send = Smsir::Send();
        $parameter = new \Cryptommer\Smsir\Objects\Parameters('Code', $code);
        $parameters = array($parameter);
        $send->Verify($user->mobile, 100000, $parameters);

        $this->setData([
            'new_user' => $user->new_user
        ]);
        return $this->response();
    }

    public function verify(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();
        $verifyCode = SmsVerification::where('user_id', $user->id)
            ->where('expired_at', null)
            ->where('status', 'NOT_USED')
            ->where('created_at','>',Carbon::now()->subMinute(2))
            ->where('failed_attemp','<',3)
            ->orderBy('created_at','DESC')->first();
        $invited_by = NULL;
        // if($request->invitationCode)
        // {
        //     $inviter = User::where('invitation_code',$request->invitationCode)->first();
        //     if($inviter)
        //       $invited_by = $inviter->id;
        //     else
        //     {
        //         $this->setErrors(['invitationCode' => [$request->invitationCode]]);
        //         $this->setStatus(422);
        //         return $this->response();
        //     }
        // }
        // && $verifyCode->created_at->gt(Carbon::now()->subMinute(2))
        if ($verifyCode) {
            if ($verifyCode->code == $request->code) {
                $verifyCode->expired_at = Carbon::now();
                $verifyCode->status = 'VERIFIED';
                $user = User::where('mobile', $request->mobile)->first();
                $user->api_token = Str::random(80);
                $user->mobileVerify = 1;
                $user->save();
                $this->setData([
                    'api_token' => $user->api_token,
                    'payStatus' => $user->payStatus,
                    'new_user' => $user->new_user,
                    'amount'  => Service::where('type','SUBSCRIPTION')->first()->amount
                ]);
            } else {
                $verifyCode->failed_attemp += 1;
                if($verifyCode->failed_attemp > 2)
                    $verifyCode->status = 'FAILED_ATTEMPT';
                $this->setErrors(['code' => ['کد وارد شده صحیح نمیباشد']]);
                $this->setStatus(401);
            }
            $verifyCode->save();
            return $this->response();
        } else {
            if ($verifyCode) {
                $verifyCode->status = 'TIME_LEFT';
                $verifyCode->expired_at = Carbon::now();
                $verifyCode->save();
            }
            $this->setErrors(['code' => ['کد تایید منقضی شده است']]);
            $this->setStatus(403);
            return $this->response();
        }
    }

    public function excel(Request $request)
    {
        $file = file_get_contents('words.txt');
        $words = explode("\n",$file);
        $data = [];
        foreach($words as $key => $word)
        {
            $word = explode(':',$word);
            if(sizeof($word) == 2)
             $data[$key] = [
                'word' => $word[0],
                'translation'=> $word[1],
                'orderIndex' => $key+1,
                'updated_at' => Carbon::now()
             ];
             sleep(0.01);
        }
        Word::insert($data);
    }
}
