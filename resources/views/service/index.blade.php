@extends('layout.master')
@section('pageTitle')
سرویس ها
@endsection

@section('services')
active
@endsection

@section('content')
   <div class="row">
      <table class="table table-bordered">
        <thead class="table thead-dark">
          <tr>
            <th>نام سرویس</th>
            <th>مبلغ</th>
            <th>استفاده شده</th>
            <th>استفاده شده موفق</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{$service->name}}</td>
                    <td>{{$service->amount}}</td>
                    <td>{{$service->countOrder}}</td>
                    <td>{{$service->countSuccessOrder}}</td>
                    <td>
                        <a class="fa fa-eye" href="{{url('panel/services/'.$service->id)}}"></a>
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
