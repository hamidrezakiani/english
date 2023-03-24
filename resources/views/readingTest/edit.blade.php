@extends('layout.master')
@section('pageTitle')
  تست کلمه شماره {{$test->orderIndex}}
@endsection

@section('word-tests')
active
@endsection

@section('content')
    {{-- add passage modal --}}
   <div class="modal fade" id="save-passage-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">متن جدید</h5>
      </div>
      <form action="{{url('readings')}}" method="POST">
        @csrf
      <div class="modal-body" style="direction: ltr !important;text-align: left">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">reading</label>
                <input type="hidden" name="test_id" value="{{$test->id}}">
                <textarea name="text" class="form-control" rows="15" cols="20"></textarea>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">translate</label>
                <textarea style="text-align: right;direction: rtl" name="translate" class="form-control" rows="15" cols="20"></textarea>
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
   {{-- end add passage modal --}}

   {{-- add question modal --}}
        <div class="modal fade" id="save-question-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">سوال جدید</h5>
      </div>
      <form action="{{url('questions')}}" method="POST">
        @csrf
      <div class="modal-body" style="direction: ltr !important;text-align: left">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">question</label>
                <input type="hidden" name="foreign_id" id="foreign-id" value="">
                <input type="hidden" name="type" value="READING_TEST">
                <input type="text" value="" class="form-control col-12" style="min-width: max-content" name="question">
              </div>
              <div class="form-group">
                    <label for="recipient-name" class="col-form-label">1.</label>
                    <input type="radio" name="trueAnswer" checked value="0">
                    <input type="text" class="form-control col-xl-12" style="min-width: max-content" name="answer[0]">
                    <label for="recipient-name" class="col-form-label">2.</label>
                    <input type="radio" name="trueAnswer" value="1">
                    <input type="text" class="form-control col-xl-12" style="min-width: max-content" name="answer[1]">
                    <label for="recipient-name" class="col-form-label">3.</label>
                    <input type="radio" name="trueAnswer" value="2">
                    <input type="text" class="form-control col-xl-12" style="min-width: max-content" name="answer[2]">
                    <label for="recipient-name" class="col-form-label">4.</label>
                    <input type="radio" name="trueAnswer" value="3">
                    <input type="text" class="form-control col-xl-12" style="min-width: max-content" name="answer[3]">
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
   {{-- end add question modal --}}
  <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">سوال جدید</h5>
      </div>
      <form action="}" method="POST" id="delete-form">
        @csrf
      <div class="modal-body">
              آیا میخواهید این سوال را حذف کنید؟
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">خیر</button>
        <button type="submit" class="btn btn-danger mr-4">بله</a>
      </div>
      </form>
    </div>
   </div>
  </div>


   <div class="row">
      <form class="col-6" id="form-edit-title" action="{{url('reading-tests/'.$test->id)}}" method="POST" style="display: none">
          @csrf
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">شماره:</label>
            <input type="number" class="form-control" name="index" id="index-input">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">عنوان:</label>
            <textarea class="form-control" name="title" id="title-input"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success" id="edit-save-btn">ثبت تغییرات</button>
            <i class="btn btn-danger" id="edit-cancel-btn">انصراف</i>
          </div>
      </form>
          <div class="col-12" id="div-title">
            <label for="message-text" class="col-form-label mb-5"> <h4 style="display:inline">عنوان :</h4> {{$test->title}}</label>
            <a class="fa fa-edit text-primary" id="edit-title-btn" style="font-size: 25px;cursor: pointer;"></a>
          </div>
   </div>
   <div class="row mb-3">
    <button class="btn btn-success" data-toggle="modal" data-target="#save-passage-modal">متن جدید</button>
   </div>

   @foreach ($test->readings as $reading)
       <div class="row" style="direction: ltr !important">
        <div class="col-12">
             <label for="" class="col-form-label-lg" style="display: block">
                متن شماره {{$reading->orderIndex}}
                <a class="fa fa-edit text-primary ml-2 edit-grammar" data-id="{{$reading->id}}" style="cursor: pointer;font-size: 20px"></a>
                <a class="fa fa-trash text-danger ml-2 delete-grammar" data-toggle="modal" data-target="#delete-modal" data-id="{{$reading->id}}" style="cursor: pointer;font-size: 20px"></a>
            </label>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <textarea class="form-control" disabled cols="30" style="direction: rtl;text-align: right" rows="15">{{$reading->translate}}</textarea>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <textarea class="form-control" disabled cols="30" rows="15">{{$reading->text}}</textarea>
        </div>

      @foreach ($reading->questions as $item)
          <div class="col-12 bg-white question-box mb-4" data-id="{{$item->id}}" style="direction: ltr !important;text-align:left !important">
             <label for="" class="col-form-label-lg" style="display: block">
                {{$item->orderIndex}}.{{$item->question}}
                <a class="fa fa-edit text-primary ml-2 edit-question" data-id="{{$item->id}}" style="cursor: pointer;font-size: 20px"></a>
                <a class="fa fa-tumblr-square ml-2 edit-translate text-success" data-id="{{$item->id}}" style="cursor: pointer;font-size: 20px"></a>
                <a class="fa fa-trash text-danger ml-2 delete-question" data-toggle="modal" data-target="#delete-modal" data-id="{{$item->id}}" style="cursor: pointer;font-size: 20px"></a>
            </label>
             @foreach ($item->answers as $key => $answer)
                 <label for="" class="col-form-label @if($answer->status) text-success @endif" style="display: block">{{$key+1}}.{{$answer->text}}</label>
             @endforeach
          </div>
          <div class="col-12 bg-white form-question-box" data-id="{{$item->id}}" style="text-align:left;display:none">
             <form action="{{url('questions/'.$item->id)}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">question</label>
                <input type="text" value="{{$item->question}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" style="min-width: max-content" name="question">
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">number</label>
                <input type="number" value="{{$item->orderIndex}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" style="min-width: max-content" name="orderIndex">
              </div>
              <div class="form-group">
                @foreach($item->answers as $key => $answer)
                    <label for="recipient-name" class="col-form-label">{{$key+1}}.</label>
                    <input type="radio" @if($answer->status) checked @endif name="trueAnswer" value="{{$answer->id}}">
                    <input type="hidden" name="answer[{{$key}}][id]" value="{{$answer->id}}">
                    <input type="text" value="{{$answer->text}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" style="min-width: max-content" name="answer[{{$key}}][text]">
                @endforeach

              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">ثبت تغییرات</button>
                <i class="btn btn-danger edit-cancel-btn" data-id="{{$item->id}}">انصراف</i>
              </div>
            </form>
          </div>

          <div class="col-12 bg-white form-translate-box" data-id="{{$item->id}}" style="text-align:left;display:none">
             <form action="{{url('questions/'.$item->id)}}" style="direction: rtl" method="POST">
              @csrf
              <div class="form-group">
                <label for="recipient-name" style="width: 100%;text-align: right"  class="col-form-label">ترجمه سوال</label>
                <input type="text" value="{{$item->translate}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" style="min-width: max-content;direction: rtl;text-align: right" name="translate">
              </div>
              <div class="form-group">
                <label for="recipient-name" style="width: 100%;text-align: right" class="col-form-label">جواب تشریحی</label>
                <textarea class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" style="direction: rtl;text-align: right" name="solve" id="" cols="15" rows="6">{{$item->solve}}</textarea>
            </div>
              <div class="form-group">
                @foreach($item->answers as $key => $answer)
                    <label for="recipient-name" style="width: 100%;text-align: right" class="col-form-label">ترجمه گزینه {{$key+1}}</label>
                    <input type="hidden" name="answer[{{$key}}][id]" value="{{$answer->id}}">
                    <input type="text"  value="{{$answer->translate}}" class="form-control @if($answer->status) bg-success @endif col-xl-4 col-lg-5 col-md-7 col-sm-10" style="min-width: max-content;direction: rtl;text-align: right" name="answer[{{$key}}][translate]">
                @endforeach

              </div>
              <div class="form-group" style="text-align: right">
                <button type="submit" class="btn btn-success">ثبت تغییرات</button>
                <i class="btn btn-danger edit-translate-cancel-btn" data-id="{{$item->id}}">انصراف</i>
              </div>
            </form>
          </div>
      @endforeach
   </div>
   <div class="row">
      @if(sizeOf($reading->questions) < 20)
      <button class="btn btn-success mt-3 mr-2 add-question-btn" data-id="{{$reading->id}}" data-toggle="modal" data-target="#save-question-modal">افزودن سوال</button>
      @endif
   </div>
   @endforeach



@endsection

@section('js')
<script>
    $(document).on('click','#edit-title-btn',function(){
       document.getElementById('form-edit-title').style.display = 'block';
       document.getElementById('div-title').style.display = 'none';
       document.getElementById('index-input').value = {{$test->orderIndex}};
       document.getElementById('title-input').value = '{{$test->title}}';
       document.getElementById('reading-input').value = '{{$test->reading}}';
    });
    $(document).on('click','.add-question-btn',function(){
       document.getElementById('foreign-id').value = `${$(this).data('id')}`;
    });



    $(document).on('click','#edit-cancel-btn',function(){
       document.getElementById('form-edit-title').style.display = 'none';
       document.getElementById('div-title').style.display = 'block';
    });

    $(document).on('click','.edit-question',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-question-box[data-id="${id}"]`).style.display = 'block';
        document.querySelector(`.question-box[data-id="${id}"]`).style.display = 'none';
    });
    $(document).on('click','.edit-cancel-btn',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-question-box[data-id="${id}"]`).style.display = 'none';
        document.querySelector(`.question-box[data-id="${id}"]`).style.display = 'block';
    })

    $(document).on('click','.edit-translate',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-translate-box[data-id="${id}"]`).style.display = 'block';
        document.querySelector(`.question-box[data-id="${id}"]`).style.display = 'none';
    });
    $(document).on('click','.edit-translate-cancel-btn',function(){
        var id = $(this).data('id');
        document.querySelector(`.form-translate-box[data-id="${id}"]`).style.display = 'none';
        document.querySelector(`.question-box[data-id="${id}"]`).style.display = 'block';
    })

    $(document).on('click','.delete-question',function(){
       document.getElementById('delete-form').setAttribute('action',`{{url('questions/delete')}}/${$(this).data('id')}`);
    });
</script>
@endsection
