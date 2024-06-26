@extends('layout.master')
@section('pageTitle')
کلمات مشابه
@endsection

@section('similar-words')
active
@endsection
@section('content')

  <div class="modal fade" id="new-word-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">افزودن کلمه جدید</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">انگلیسی:</label>
            <input type="text" class="form-control" id="word-input">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">معانی:</label>
            <textarea class="form-control" id="translation-input"></textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">مکان:</label>
            <input type="number" value="1" class="form-control" id="index-input">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-save-modal" data-dismiss="modal">بستن</button>
        <button type="button" class="btn btn-primary mr-4" id="save-button">ذخیره</button>
      </div>
    </div>
  </div>
  </div>



  <div class="modal fade" id="jump-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">انتقال</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">انتقال به:</label>
            <input type="number" value="1" class="form-control" id="jump-index-input">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-jump-modal" data-dismiss="modal">بستن</button>
        <button type="button" class="btn btn-primary mr-4" id="jump-button">ذخیره</button>
      </div>
    </div>
   </div>
  </div>


  <div class="modal fade" id="swap-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">جا به جایی</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"> جا به جایی با:</label>
            <input type="number" value="1" class="form-control" id="swap-index-input">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-swap-modal" data-dismiss="modal">بستن</button>
        <button type="button" class="btn btn-primary mr-4" id="swap-button">ذخیره</button>
      </div>
    </div>
   </div>
  </div>


  <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">حذف</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">آیا میخواهید لغت <i id="delete-word"></i> را حذف کنید؟</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close-delete-modal" data-dismiss="modal">خیر</button>
        <button type="button" class="btn btn-danger mr-4" id="delete-button">بله</button>
      </div>
    </div>
   </div>
  </div>

 <div class="row mb-3">
    <div class="col-lg-2 col-md-3 col-sm-4 mt-1">
       <button class="btn btn-success" data-toggle="modal" data-target="#new-word-modal">کلمه جدید</button>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-5 mt-1">
       <input type="text" id="search" class="form-control" placeholder="جستجو">
    </div>
 </div>
 <div class="row">
   <table class="table table-bordered">
      <thead class="table thead-dark">
        <tr>
          <th>ردیف</th>
          <th>کلمه</th>
          <th>ترجمه</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody id="tbody-word">
      </tbody>
   </table>
 </div>
 <div class="row">
    <div class="col-lg-4 col-md-3 col-sm-1"></div>
    <div class="col-lg-4 col-md-6 col-sm-10" style="display: flex">
      <button class="btn btn-info mt-1 page-link" id="next-page-button">صفحه بعد</button>
     <select name="example1_length" id="select-page"  aria-controls="example1" class="form-control form-control-sm mt-2 mr-2">

     </select>
   <button class="btn btn-info mt-1 mr-2 page-link" id="prev-page-button">صفحه قیل</button>
   </div>
   <div class="col-lg-4 col-md-3 col-sm-1"></div>
   </div>
@endsection

@section('js')
<script>
    var nextPageUrl = null;
    var lastPageUrl = null;
    var per_page = 0;
    var current_page = 1;
    var pendiing = false;
    var jumpId = null;
    var swapId = null;
    var deleteId = null;
    loadData('{{env('API_URL')}}/similar-words?');
    // $(window).scroll(function() {
    // if($(window).scrollTop() == $(document).height() - $(window).height()) {
    //     if(nextPageUrl != null && !pendiing)
    //       loadData();
    //  }
    // });

    function loadData(url){
        pendiing = true;
        $.ajax({
            'url':`${url}&per_page=100&agent=panel`,
            'method':'GET',
            'timeout':0,
        }).done(function(response){
            pendiing = false;
            nextPageUrl = response.data.next_page_url;
            prevPageUrl = response.data.prev_page_url;
            last_page = response.data.last_page;
            per_page = response.data.per_page;
            current_page = response.data.current_page;
            console.log(response);
            insertData(response.data.data);
        });
    }

    function insertData(words,clear = 0){
       document.getElementById('next-page-button').setAttribute('data-url',nextPageUrl);
       document.getElementById('prev-page-button').setAttribute('data-url',prevPageUrl);
       var selectPageElement = document.getElementById('select-page');
       selectPageElement.innerHTML = '';
       for(i=1;i<=last_page;i++)
       {
          var option = document.createElement('OPTION');
          option.innerHTML = i;
          option.value=`{{env('API_URL')}}/similar-words?page=${i}`;
          if(current_page == i)
            option.selected = true;

           selectPageElement.appendChild(option);
       }
       var tbody = document.getElementById('tbody-word');
       tbody.innerHTML = '';
       if(clear)
         tbody.innerHTML = '';
       for(key in words)
       {
          var word = words[key];
          var tr = document.createElement('TR');
          var td  = document.createElement('TD');
          var index = word.orderIndex;
          tr.setAttribute('data-index',index);
          tr.className = 'words';
          td.innerHTML = index;
          tr.appendChild(td);
          td = document.createElement('TD');
          td.className = 'word-cell';
          td.setAttribute('data-id',word.id);
          td.innerHTML = word.word;
          tr.appendChild(td);
          td = document.createElement('TD');
          td.className = 'translation-cell';
          td.setAttribute('data-id',word.id);
          td.innerHTML = word.translation;
          tr.appendChild(td);
          td = document.createElement('TD');
          var i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-up text-success mr-1 move-up';
          i.style.fontSize = '25px';
          i.setAttribute('data-id',word.id);
          if(word.orderIndex != 1)
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-down text-danger mr-1 move-down';
          i.style.fontSize = '25px';
          i.setAttribute('data-id',word.id);
          if(!(key == words.length - 1 && nextPageUrl == null))
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-mail-forward text-dark mr-1 jump';
          i.setAttribute('data-toggle','modal');
          i.setAttribute('data-target','#jump-modal');
          i.style.fontSize = '15px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-arrows text-dark mr-1 swap';
          i.setAttribute('data-toggle','modal');
          i.setAttribute('data-target','#swap-modal');
          i.style.fontSize = '15px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-trash-o text-danger mr-1 delete';
          i.setAttribute('data-toggle','modal');
          i.setAttribute('data-target','#delete-modal');
          i.style.fontSize = '15px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          tr.appendChild(td);
          tbody.appendChild(tr);
       }
    }

    $(document).on('click','.move-up',function(event){
        if(!pendiing)
        {
          pendiing = true;
          $('.move-up').toggleClass('disable');
          $('.move-down').toggleClass('disable');
          $('.jump').toggleClass('disable');
          $('.swap').toggleClass('disable');
         var currentTr = this.parentElement.parentElement;
          var id = $(this).attr('data-id');
           $.ajax({
            'url':`{{env('API_URL')}}/similar-word-move-up/${id}`,
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            $('.jump').toggleClass('disable');
            $('.swap').toggleClass('disable');
            pendiing = false;
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    }
    });

    $(document).on('click','.move-down',function(event){
        if(!pendiing)
        {
          pendiing = true;
          $('.move-up').toggleClass('disable');
          $('.move-down').toggleClass('disable');
          $('.jump').toggleClass('disable');
          $('.swap').toggleClass('disable');
         var currentTr = this.parentElement.parentElement;
          var id = $(this).attr('data-id');
           $.ajax({
            'url':`{{env('API_URL')}}/similar-word-move-down/${id}`,
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            $('.jump').toggleClass('disable');
            $('.swap').toggleClass('disable');
            pendiing = false;
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    }
    });

    $(document).on('click','.jump',function(){
        jumpId = this.getAttribute('data-id');
    });

    $(document).on('click','#jump-button',function(){
        $('.move-up').toggleClass('disable');
        $('.move-down').toggleClass('disable');
        $('.jump').toggleClass('disable');
        $('.swap').toggleClass('disable');
        var targetIndex = document.getElementById('jump-index-input').value;
        $.ajax({
            'url':`{{env('API_URL')}}/similar-word-jump`,
            'data':{
              'id':jumpId,
              'targetIndex':targetIndex,
            },
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            $('.jump').toggleClass('disable');
            $('.swap').toggleClass('disable');
            document.getElementById('close-jump-modal').click();
            pendiing = false;
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    });

    $(document).on('click','.swap',function(){
        swapId = this.getAttribute('data-id');
    });

    $(document).on('click','#swap-button',function(){
        $('.move-up').toggleClass('disable');
        $('.move-down').toggleClass('disable');
        $('.jump').toggleClass('disable');
        $('.swap').toggleClass('disable');
        var targetIndex = document.getElementById('swap-index-input').value;
        $.ajax({
            'url':`{{env('API_URL')}}/similar-word-swap`,
            'data':{
              'id':swapId,
              'targetIndex':targetIndex,
            },
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            $('.jump').toggleClass('disable');
            $('.swap').toggleClass('disable');
            document.getElementById('close-swap-modal').click();
            pendiing = false;
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    });

    $(document).on('keyup','#search',function(){
        var searchQuery = this.value;
        $.ajax({
            'url':`{{env('API_URL')}}/similar-words?flag=search&q=${searchQuery}&agent=panel`,
            'method':'GET',
            'timeout':0,
        }).done(function(response){
            nextPageUrl = response.data.next_page_url;
            per_page = response.data.per_page;
            current_page = response.data.current_page;
            console.log(response);
            insertData(response.data.data,1);
        });
    });

    $(document).on('click','#save-button',function(){
       $.ajax({
            'url':`{{env('API_URL')}}/similar-words`,
            'method':'POST',
            'data':{
               'word':document.getElementById('word-input').value,
               'translation':document.getElementById('translation-input').value,
               'orderIndex':document.getElementById('index-input').value,
            },
            'timeout':0,
        }).done(function(response){
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
            document.getElementById('close-save-modal').click();
        });
    });

    $(document).on('dblclick','.word-cell',function(){
        var input = document.createElement('INPUT');
        input.setAttribute('type','text');
        input.className = 'form-control input-word';
        input.value = this.innerHTML;
        input.setAttribute('data-id',this.getAttribute('data-id'));
        this.innerHTML = '';
        this.appendChild(input);
    });

    $(document).on('focusout','.input-word',function(){
        var word = this.value;
        var id = this.getAttribute('data-id');
         $.ajax({
            'url':`{{env('API_URL')}}/similar-words/${id}?word=${word}`,
            'method':'PUT',
            'timeout':0,
        }).done(function(response){
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    });

    $(document).on('dblclick','.translation-cell',function(){
        var input = document.createElement('INPUT');
        input.setAttribute('type','text');
        input.className = 'form-control input-translation';
        input.value = this.innerHTML;
        input.setAttribute('data-id',this.getAttribute('data-id'));
        this.innerHTML = '';
        this.appendChild(input);
    });

    $(document).on('focusout','.input-translation',function(){
        var translation = this.value;
        var id = this.getAttribute('data-id');
         $.ajax({
            'url':`{{env('API_URL')}}/similar-words/${id}?translation=${translation}`,
            'method':'PUT',
            'timeout':0,
        }).done(function(response){
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
        });
    });

    $(document).on('click','.delete',function(){
        var tr = this.parentElement.parentElement;
        deleteId = this.getAttribute('data-id');
        var tdWord = tr.getElementsByTagName('td')[1];
        document.getElementById('delete-word').innerHTML = tdWord.innerHTML;
    });

    $(document).on('click','#delete-button',function(){
         $.ajax({
            'url':`{{env('API_URL')}}/similar-words/${deleteId}`,
            'method':'DELETE',
            'timeout':0,
        }).done(function(response){
            loadData(`{{env('API_URL')}}/similar-words?page=${current_page}`);
            document.getElementById('close-delete-modal').click();
        });
    });

    $(document).on('click','.page-link',function(){
       var url = this.getAttribute('data-url');
       loadData(url);
    });

    $(document).on('change','#select-page',function(){
       loadData(this.value);
    })
</script>
@endsection

@section('css')
   <link rel="stylesheet" href="{{asset('dist/css/word.css')}}">
@endsection
