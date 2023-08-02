@extends('layout.master')
@section('pageTitle')
  سرویس {{$service->name}}
@endsection

@section('word-tests')
active
@endsection

@section('content')
<div class="row bg-white" style="display: flex;flex-direction: row;justify-content: center">
  @if(session()->has('status'))
    @if(session()->get('status') == 'SUCCESS')
     <div class="alert alert-success" style="position: absolute;display:none;top:35%;" id="success-alert">
        <div style="display: flex; flex-direction: row;justify-content: center;align-items: center;">
          <i class="fa fa-check-circle" style="font-size: 50px"></i>
          <span style="font-size: 20px;margin-right: 10px">تغییرات با موفقیت ذخیره شد</span>
        </div>
     </div>
    @endif
  @endif
</div>
<div class="row p-5" id="form-div" style="display: none">
  <form class="col-6" action="{{url('panel/services/'.$service->id)}}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="name" class="col-form-label">نام سرویس</label>
        <input type="text" class="form-control" name="name" id="name" value="{{$service->name}}">
      </div>
      <div class="form-group">
        <label for="amount" class="col-form-label">هزینه</label>
        <input type="number" class="form-control" name="amount" id="amount" value="{{$service->amount}}">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-success">ثبت تغییرات</button>
        <i class="btn btn-danger" id="btn-cancel">انصراف</i>
      </div>
  </form> 
</div>
   <div class="row bg-white p-5" id="data-div">
      <div class="col-6">
         <div class="form-group">
             <div class="row">
              <span class="m-1" style="font-size: 20px;font-weight: 500">نام سرویس : </span><span class="badge bg-secondary m-2" style="font-size: 16px;font-weight: 300;padding:5px 10px">{{$service->name}}</span>
             </div>
             <div class="row">
              <span class="m-1" style="font-size: 20px;font-weight: 500">هزینه سرویس : </span><span class="badge text-success m-2" style="font-size: 16px;font-weight: 600">{{number_format($service->amount)}} تومان</span>
             </div>
         </div>
         <div class="form-group">
            <button class="btn btn-primary" id="btn-edit">ویرایش</button>
         </div>
      </div>
      <div class="col-6">
        <div class="col-6">
          <div class="form-group">
              <div class="row">
               <span class="m-1" style="font-size: 20px;font-weight: 500"> کل خرید : </span><span class="badge text-secondary m-2" style="font-size: 16px;font-weight: 600;">{{$service->countOrder}} اشتراک</span>
              </div>
              <div class="row">
               <span class="m-1" style="font-size: 20px;font-weight: 500"> خرید موفق : </span><span class="badge text-success m-2" style="font-size: 16px;font-weight: 600">{{$service->countSuccessOrder}} اشتراک</span>
              </div>
          </div>
       </div>
      </div>
   </div>
   
@endsection

@section('js')
   <script>
      $('#btn-edit').on('click',function(){
          $('#data-div').slideToggle(200,"linear",function(){
            $("#form-div").slideDown(200);
          });
      })
      $('#btn-cancel').on('click',function(){
          $('#form-div').slideToggle(200,"linear",function(){
            $("#data-div").slideDown(200);
          });
      })
      $("#success-alert").fadeIn(1000,function(){
        setTimeout(function() {
          $("#success-alert").fadeOut(1000);
          }, 3000);
      });
   </script>
@endsection

