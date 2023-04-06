@extends('layout.master')
@section('pageTitle')
  گرامر
@endsection

@section('grammars')
active
@endsection

@section('css')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endsection

@section('content')

<div class="modal fade" id="save-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
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
                <div class="card card-outline card-info">
            <!-- /.card-header -->
            <div class="card-body pad">
              <div class="mb-3">
                <textarea name="text" class="textarea" placeholder="لطفا متن خود را وارد کنید"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
            </div>
          </div>
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
            <div
              style="direction:unset"
            >{!!$item->text!!}</div>
          </div>
          <div class="col-12 bg-white form-grammar-box" data-id="{{$item->id}}" style="display:none">
             <form action="{{url('grammars/'.$item->id)}}" method="POST">
              @csrf
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">عنوان درس</label>
                <input type="text" value="{{$item->title}}" class="form-control col-xl-4 col-lg-5 col-md-7 col-sm-10" name="title">
              </div>
              <div class="form-group">
                {{-- <label for="recipient-name" class="col-form-label">متن</label>
                <textarea name="text" id="editor1" cols="30" rows="10">{{$item->text}}</textarea> --}}
                <textarea name="text" id="text-editor">{!!$item->text!!}</textarea>
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
{{-- <script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{asset('plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script> --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/super-build/ckeditor.js"></script> --}}
<script src="{{asset('plugins/ckeditor5/index.js')}}"></script>

<script>
   $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    // ClassicEditor
    //   .create(document.querySelector('#editor1'))
    //   .then(function (editor) {
    //     // The editor instance
    //   })
    //   .catch(function (error) {
    //     console.error(error)
    //   })

      //  ClassicEditor
      // .create(document.querySelector('#editor'))
      // .then(function (editor) {
      //   // The editor instance
      // })
      // .catch(function (error) {
      //   console.error(error)
      // })

    // bootstrap WYSIHTML5 - text editor

      // $('.textarea').wysihtml5({
      //     toolbar: { fa: true }
      // })


  });
</script>
<script>
    // ClassicEditor
    //     .create( document.querySelector( '#text-editor' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );

     CKEDITOR.ClassicEditor.create(document.getElementById("text-editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Welcome to CKEditor 5!',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType
                    'MathType'
                ]
            });
</script>
@endsection
