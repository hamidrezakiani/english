@extends('layout.master')
@section('pageTitle')
سفارشات
@endsection

@section('orders')
active
@endsection

@section('content')
   <div class="row">
      <table class="table table-bordered">
        <thead class="table thead-dark">
          <tr>
            <th>شماره کاربر</th>
            <th>مبلغ</th>
            <th>کد تخفیف</th>
            <th>تاریخ ایجاد</th>
            <th>وضعیت پرداخت</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->user->mobile}}</td>
                    <td>{{$order->payable}}</td>
                    <td>{{$order->discount?->code ?? "ندارد"}}</td>
                    <td>{{verta($order->created_at)}}</td>
                    <td>{{$order->payments()->where('status','PAID')->exists() ? "پرداخت شده" : "پرداخت نشده"}}</td>
                    <td>
                        <a class="fa fa-eye" href="{{url('panel/orders/'.$order->id)}}"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
   </div>
@endsection

@section('js')

@endsection

@section('css')
    <style>
      td,th{
        text-align: center;
        vertical-align: middle;
      }
    </style>
@endsection
