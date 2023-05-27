<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::guard('api')->user();
        return response()->json(['user' => json_encode($user)],200);
    }
}
