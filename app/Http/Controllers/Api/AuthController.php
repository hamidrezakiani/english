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
class AuthController extends Controller
{
    use ResponseTemplate;
    public function verificationCode(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();
        if(!$user)
          $user = User::create([
            'mobile' => $request->mobile,
            'ip'     => $request->ip()
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
            'new_user' => $user->newUser
        ]);
        return $this->response();
    }

    public function verify(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();
        $verifyCode = SmsVerification::where('user_id', $user->id)
            ->where('expired_at', null)
            ->where('status', 'NOT_USED')->first();
        $invited_by = NULL;
        if($request->invitationCode)
        {
            $inviter = User::where('invitation_code',$request->invitationCode)->first();
            if($inviter)
              $invited_by = $inviter->id;
            else
            {
                $this->setErrors(['invitationCode' => [$request->invitationCode]]);
                $this->setStatus(422);
                return $this->response();
            }
        }
        if ($verifyCode && $verifyCode->created_at->gt(Carbon::now()->subMinute(2))) {
            $verifyCode->expired_at = Carbon::now();
            if ($verifyCode->code == $request->code) {
                $verifyCode->status = 'VERIFIED';
                $user = User::where('mobile', $request->mobile)->first();
                $user->api_token = Str::random(80);
                if($user->new_user)
                {
                   $user->name = $request->name;
                   $user->invited_by = $invited_by;
                   $user->new_user = 0;
                }
                $user->mobileVerify = 1;
                $user->save();
                $this->setData([
                    'api_token' => $user->api_token,
                    'payStatus' => $user->payStatus,
                    'new_user' => $user->new_user,
                ]);
            } else {
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

    // public function excel(Request $request)
    // {
    //     $file = file_get_contents('463104.csv');
    //     $words = explode("\n",$file);
    //     $data = [];
    //     foreach($words as $key => $word)
    //     {
    //         $word = explode(',',$word);
    //         if(sizeof($word) == 2)
    //          $data[$key] = [
    //             'word' => $word[0],
    //             'translation'=> $word[1],
    //             'orderIndex' => $key+1
    //          ];
    //     }
    //     Word::insert($data);
    // }
}
