@extends('layout.master')
@section('pageTitle')
  گرامر
@endsection

@section('grammars')
active
@endsection

@section('content')

<div class="modal fade" id="save-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">درس جدید</h5>
      </div>
      <form action="{{url('grammars')}}" method="POST">
        @csrf
      <div class="modal-body">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">عنوان درس</label>
                <input type="text" value="" class="form-control col-12" style="min-width: max-content" name="title">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">متن</label>
                <textarea class="form-control" name="text" id="" cols="30" rows="10"></textarea>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">انصراف</button>
        <button type="submit" class="btn btn-success mr-4">ذخیره</a>
      </div>
      </form>
    </div>
   </div>
  </div>

  <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">سوال جدید</h5>
      </div>
      <form action="" method="POST" id="delete-form">
        @csrf
      <div class="modal-body">
              آیا میخواهید این درس را حذف کنید؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">خیر</button>
        <button type="submit" class="btn btn-danger mr-4">بله</a>
      </div>
      </form>
    </div>
   </div>
  </div>

   <div class="row mb-3">
    <button class="btn btn-success" data-toggle="modal" data-target="#save-modal">درس جدید</button>
   </div>


   <div class="row">
      @foreach ($grammars as $key => $item)
          <div class="col-12 bg-white grammar-box mb-4" data-id="{{$item->id}}">
             <label for="" class="col-form-label-lg" style="display: block">
                {{$key + 1}}.{{$item->title}}
                <a class="fa fa-edit text-primary ml-2 edit-grammar" data-id="{{$item->id}}" style="cursor: pointer;font-size: 20px"></a>
                <a class="fa fa-trash text-danger ml-2 delete-grammar" data-toggle="modal" data-target="#delete-modal" data-id="{{$item->id}}" style="cursor: pointer;font-size: 20px"></a>
            </label>
            <textarea class="form-control" disabled cols="30" rows="10">{{$item->text}}</textarea>
          </div>
          <div class="col-12 bg-white form-grammar-box" data-id="{{$item->id}}" style="display:none">
             <form action="{{url('grammars/'.$item->id)}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">عنوان درس</label>
                <input type="text" value="{{$item->title}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" name="title">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">متن</label>
                <textarea class="form-control" name="text" id="" cols="30" rows="10">{{$item->text}}</textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">ثبت تغییرات</button>
                <i class="btn btn-danger edit-cancel-btn" data-id="{{$item->id}}">انصراف</i>
              </div>
            </form>
          </div>
      @endforeach
   </div>
@endsection

@section('js')
<script>


    $(document).on('click','.edit-grammar',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-grammar-box[data-id="${id}"]`).style.display = 'block';
        document.querySelector(`.grammar-box[data-id="${id}"]`).style.display = 'none';
    });
    $(document).on('click','.edit-cancel-btn',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-grammar-box[data-id="${id}"]`).style.display = 'none';
        document.querySelector(`.grammar-box[data-id="${id}"]`).style.display = 'block';
    })

    $(document).on('click','.delete-grammar',function(){
       document.getElementById('delete-form').setAttribute('action',`{{url('grammars/delete')}}/${$(this).data('id')}`);
    });
</script>

<script src="{{asset('plugins/ckeditor/ckeditor.js')}}"></script>
<script>

</script>
@endsection
