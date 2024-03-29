@extends('layout.master')
@section('pageTitle')
  پشتیبانی
@endsection

@section('support')
active
@endsection

@section('content')
  <div class="row">
    <form action="{{url('panel/updateSupport')}}" method="POST">
        @csrf
        <textarea name="text" id="editor1" rows="10" cols="80">
                {!!$value->value!!}
        </textarea>
        <button class="btn btn-success">ذخیره</button>
    </form>

  </div>
@endsection

@section('js')
  <script src="{{asset('plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
  <script>
      CKEDITOR.replace( 'editor1' );
  </script>
@endsection
