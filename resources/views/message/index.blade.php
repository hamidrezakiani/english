@extends('layout.master')
@section('messages') active @endsection

@section('content')
   {{-- new message modal --}}
  <div class="modal fade" id="new-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
             <h4 style="width: 100%;text-align: center">ارسال پیام جدید</h4>
          </div>
          <form action="{{url('panel/messages')}}" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="new-title">عنوان</label>
                <input type="text" class="form-control" id="new-title" name="title" placeholder="عنوان پیام">
              </div>
              <div class="form-group">
                <label for="new-text">متن</label>
                <textarea name="text" class="form-control" id="new-text" cols="30" rows="10" placeholder="متن پیام"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary m-2" type="button" data-dismiss="modal">انصراف</button>
              <button class="btn btn-success m-2" type="submit">ارسال</button>
            </div>
          </form>
        </div>
    </div>
  </div>
  {{-- end new message modal --}}


  {{-- edit message modal --}}
  <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
             <h4 style="width: 100%;text-align: center">ویرایش پیام</h4>
          </div>
          <form action="" id="edit-form" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="edit-title">عنوان</label>
                <input type="text" class="form-control" id="edit-title" name="title" placeholder="عنوان پیام">
              </div>
              <div class="form-group">
                <label for="edit-text">متن</label>
                <textarea name="text" class="form-control" id="edit-text" cols="30" rows="10" placeholder="متن پیام"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary m-2" type="button" data-dismiss="modal">انصراف</button>
              <button class="btn btn-primary m-2" type="submit">اعمال</button>
            </div>
          </form>
        </div>
    </div>
  </div>
  {{-- end edit message modal --}}


  {{-- delete message modal --}}
  <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
             <h4 style="width: 100%;text-align: center">حذف پیام</h4>
          </div>
            <div class="modal-body">
               آیا میخواهید پیام شماره <span id="message-index"></span> را حذف کنید؟
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary m-2" type="button" data-dismiss="modal">انصراف</button>
              <form action="" method="POST" id="delete-form">
                @csrf
                <button class="btn btn-danger m-2" type="submit">حذف</button>
              </form>
            </div>
        </div>
    </div>
  </div>
  {{-- end delete message modal --}}


  <div class="row">
    <button class="btn btn-success m-2" data-toggle="modal" data-target="#new-modal">پیام جدید</button>
  </div>
  <div class="row">
     <table class="table table-bordered">
         <thead class="thead-dark">
            <tr>
                <th>ردیف</th>
                <th>عنوان</th>
                <th>متن</th>
                <th>عملیات</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($messages as $index => $message)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$message->title}}</td>
                    <td>{{$message->text}}</td>
                    <td>
                        <button class="btn btn-primary edit" data-toggle="modal" data-target="#edit-modal" data-id="{{$message->id}}" data-title="{{$message->title}}" data-text="{{$message->text}}">ویرایش</button>
                        <button class="btn btn-danger delete" data-toggle="modal" data-target="#delete-modal" data-id="{{$message->id}}" data-index="{{$index+1}}">حذف</button>
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
       const id = $(this).data('id');
       const index = $(this).data('index');
       $('#message-index').html(index);
       $('#delete-form').attr('action',`{{url('panel/messages/delete')}}/${id}`);
    });

    $(document).on('click','.edit',function(){
        const id = $(this).data('id');
        const title = $(this).data('title');
        const text = $(this).data('text');
        $('#edit-title').val(title);
        $('#edit-text').html(text);
        $('#edit-form').attr('action',`{{url('panel/messages')}}/${id}`);
    });
  </script>
@endsection
