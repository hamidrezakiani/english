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
        <h5 class="modal-title">حذف</h5>
      </div>
     <form action="{{url('panel/reading-tests')}}" method="POST">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="title-name" class="col-form-label">عنوان تست:</label>
            <input type="text" class="form-control" name="title" id="title-name">
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

  <div class="row">
    <button class="btn btn-success" data-toggle="modal" data-target="#add-modal">افزودن تست</button>
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
                    <td>{{$discount->amount}}</td>
                    <td>{{$discount->orders()->count()}}</td>
                    <td>0</td>
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
</script>
@endsection
