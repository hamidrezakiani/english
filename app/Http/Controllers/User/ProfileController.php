<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\ResponseTemplate;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ResponseTemplate;
    public function update(Request $request)
    {
        $user = Auth::guard('api')->user();
        if($request->invitationCode)
        {
            $inviter = User::where('invitation_code',$request->invitationCode)->first();
            if($inviter)
              $invited_by = $inviter->id;
            else
            {
               $this->status(422);
               $this->errors([
                 'invitationCode' => [
                    0 => 'کد معرف اشتباه است',
                 ]
               ]);
               return $this->response();
            }
        }
        else
          $invited_by = $user->invited_by;

        $user->update([
            'name' => $request->name,
            'invited_by' => $invited_by
        ]);
        return $this->response();
    }
}
