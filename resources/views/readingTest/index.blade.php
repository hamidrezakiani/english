@extends('layout.master')
@section('pageTitle')
 تست های متن
@endsection

@section('readingTests')
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
     <form action="{{url('/reading-tests')}}" method="POST">
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
            <th>ردیف</th>
            <th>عنوان تست</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tests as $test)
                <tr>
                    <td>{{$test->orderIndex}}</td>
                    <td>{{$test->title}}</td>
                    <td>
                        <a class="fa fa-eye" href="{{url('reading-tests/'.$test->id)}}"></a>
                        <i class="fa fa-trash mr-3 delete" data-toggle="modal" data-target="#delete-modal" data-id="{{$test->id}}"></i>
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
       document.getElementById('delete-form').setAttribute('action',`{{url('reading-tests/delete')}}/${id}`);
    });
</script>
@endsection
