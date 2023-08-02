<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::with(['user','orders','paidOrders'])->get();
        return view('discount.index',compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();
        if(!$user)
           return redirect()->back()->with(['status'=>'ERROR','message' => 'کاربری با این شماره یافت نشد']);
        Discount::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'code' => $request->code,
        ]);
        return redirect()->back()->with(['status' => 'SUCCESS']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discount = Discount::with(['user','orders','paidOrders'])->find($id);
        return view('discount.show',compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount = Discount::with(['user'])->find($id);
        return view('discount.edit',compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Discount::find($id)->update([
            'user_id' => $request->user_id,
            'code' => $request->code,
            'amount' => $request->amount
        ]);

        return redirect()->to('panel/discounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Discount::find($id)->delete();
        return redirect()->to('panel/discounts');
    }
}
