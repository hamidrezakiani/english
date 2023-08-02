<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('service.index',compact('services'));
    }

    public function show($id)
    {
        $service = Service::find($id);
        return view('service.edit',compact('service'));
    }

    public function update($id,Request $request)
    {
        Service::find($id)->update([
           'name' => $request->name,
           'amount' => $request->amount
        ]);

        return redirect()->back()->with(['status' => 'SUCCESS']);
    }
}
