@extends('layout.master')
@section('pageTitle')
 کد های تخفیف
@endsection

@section('discounts')
active
@endsection

@section('content')

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">حذف</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">آیا میخواهید این تست را حذف کنید؟</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">خیر</button>
        <form action="" id="delete-form">
            <button type="submit" class="btn btn-danger mr-4" id="delete-button">بله</a>
        </form>

      </div>
    </div>
   </div>
  </div>

  <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">کد تخفیف جدید</h5>
      </div>
     <form action="{{url('panel/discounts')}}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="mobile" class="col-form-label">شماره کابر</label>
          <input type="number" class="form-control" name="mobile" id="mobile">
        </div>
          <div class="form-group">
            <label for="code" class="col-form-label">کد</label>
            <input type="text" class="form-control" name="code" id="code">
          </div>
          <div class="form-group">
            <label for="amount" class="col-form-label">مبلغ تخفیف</label>
            <input type="number" class="form-control" name="amount" id="amount">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">انصراف</button>
        <button type="submit" class="btn btn-danger mr-4" id="delete-button">ذخیره</a>
      </div>
     </form>
    </div>
   </div>
  </div>
  <div class="row" style="display: flex;flex-direction: row;justify-content: center">
    @if(session()->has('status'))
      @if(session()->get('status') == 'SUCCESS')
       <div class="alert alert-success" style="position: absolute;display:none;top:35%;" id="success-alert">
          <div style="display: flex; flex-direction: row;justify-content: center;align-items: center;">
            <i class="fa fa-check-circle" style="font-size: 50px"></i>
            <span style="font-size: 20px;margin-right: 10px">کد تخفیف با موفقیت اضافه شد</span>
          </div>
       </div>
      @else
      <div class="alert alert-danger" style="position: absolute;display:none;top:35%;" id="error-alert">
        <div style="display: flex; flex-direction: row;justify-content: center;align-items: center;">
          <i class="fa fa-check-circle" style="font-size: 50px"></i>
          <span style="font-size: 20px;margin-right: 10px">{{session()->get('message')}}</span>
        </div>
     </div>
      @endif
    @endif
  </div>
  <div class="row mb-2">
    <button class="btn btn-success" data-toggle="modal" data-target="#add-modal">افزودن کد تخفیف</button>
  </div>

   <div class="row">
      <table class="table table-bordered">
        <thead class="table thead-dark">
          <tr>
            <th>نام کاربر</th>
            <th>کد</th>
            <th>تخفیف</th>
            <th>استفاده شده</th>
            <th>استفاده شده موفق</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($discounts as $discount)
                <tr>
                    <td>{{$discount->user->name}}</td>
                    <td>{{$discount->code}}</td>
                    <td>{{number_format($discount->amount)}} تومان</td>
                    <td>{{$discount->orders()->count()}}</td>
                    <td>{{$discount->orders()->paid()->count()}}</td>
                    <td>
                        <a class="fa fa-eye" href="{{url('panel/discounts/'.$discount->id)}}"></a>
                        <i class="fa fa-trash mr-3 delete" data-toggle="modal" data-target="#delete-modal" data-id="{{$discount->id}}"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
   </div>
@endsection

@section('js')
<script>
    $(document).on('click','.delete',function(){
       var id = this.getAttribute('data-id');
       document.getElementById('delete-form').setAttribute('action',`{{url('panel/reading-tests/delete')}}/${id}`);
    });
    $("#success-alert").fadeIn(1000,function(){
        setTimeout(function() {
          $("#success-alert").fadeOut(1000);
          }, 3000);
      });
      $("#error-alert").fadeIn(1000,function(){
        setTimeout(function() {
          $("#error-alert").fadeOut(1000);
          }, 3000);
      });
</script>

@endsection

@section('css')
    <style>
      td,th{
        text-align: center;
        vertical-align: middle;
      }
    </style>
@endsection
