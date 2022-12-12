@extends('layout.master')
@section('pageTitle')
کلمات
@endsection

@section('words')
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
        <button type="button" class="btn btn-primary" id="save-button">ذخیره</button>
      </div>
    </div>
  </div>
</div>
 <div class="row mb-3">
    <div class="col-2">
       <button class="btn btn-success" data-toggle="modal" data-target="#new-word-modal">کلمه جدید</button>
    </div>
    <div class="col-4">
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
@endsection

@section('js')
<script>
    var nextPageUrl = `{{env('API_URL')}}/words?`;
    var per_page = 0;
    var current_page = 0;
    var pendiing = false;
    loadData();
    $(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {
        if(nextPageUrl != null && !pendiing)
          loadData();
     }
    });

    function loadData(){
        pendiing = true;
        $.ajax({
            'url':`${nextPageUrl}&per_page=100`,
            'method':'GET',
            'timeout':0,
        }).done(function(response){
            pendiing = false;
            nextPageUrl = response.data.next_page_url;
            per_page = response.data.per_page;
            current_page = response.data.current_page;
            console.log(response);
            insertData(response.data.data);
        });
    }

    function insertData(words,clear = 0){

       var tbody = document.getElementById('tbody-word');
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
          td.innerHTML = word.word;
          tr.appendChild(td);
          td = document.createElement('TD');
          td.innerHTML = word.translation;
          tr.appendChild(td);
          td = document.createElement('TD');
          var i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-up text-success mr-2 move-up';
          i.style.fontSize = '30px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-down text-danger mr-2 move-down';
          i.style.fontSize = '30px';
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
         var currentTr = this.parentElement.parentElement;
          var id = $(this).attr('data-id');
           $.ajax({
            'url':`{{env('API_URL')}}/word-move-up/${id}`,
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            pendiing = false;
            var currentIndex = parseInt(currentTr.getAttribute('data-index'));
            var targetIndex = currentIndex - 1;
            var tbody = document.getElementById('tbody-word');
            tbody.insertBefore(currentTr,tbody.children[currentIndex-2]);
            var targetTr = document.querySelector(`[data-index="${targetIndex}"]`);
            targetTr.firstChild.innerHTML = currentIndex;
            currentTr.firstChild.innerHTML = targetIndex;
            targetTr.setAttribute('data-index',currentIndex);
            currentTr.setAttribute('data-index',targetIndex);
        });
    }
    });

    $(document).on('click','.move-down',function(event){
        if(!pendiing)
        {
          pendiing = true;
          $('.move-up').toggleClass('disable');
          $('.move-down').toggleClass('disable');
         var currentTr = this.parentElement.parentElement;
          var id = $(this).attr('data-id');
           $.ajax({
            'url':`{{env('API_URL')}}/word-move-down/${id}`,
            'method':'POST',
            'timeout':0,
        }).done(function(response){
            $('.move-up').toggleClass('disable');
            $('.move-down').toggleClass('disable');
            pendiing = false;
            var currentIndex = parseInt(currentTr.getAttribute('data-index'));
            var targetIndex = currentIndex + 1;
            var tbody = document.getElementById('tbody-word');
            var targetTr = document.querySelector(`[data-index="${targetIndex}"]`);
            tbody.insertBefore(targetTr,tbody.children[currentIndex - 1]);
            targetTr.firstChild.innerHTML = currentIndex;
            currentTr.firstChild.innerHTML = targetIndex;
            targetTr.setAttribute('data-index',currentIndex);
            currentTr.setAttribute('data-index',targetIndex);
        });
    }
    });
    $(document).on('keyup','#search',function(){
        var searchQuery = this.value;
        $.ajax({
            'url':`{{env('API_URL')}}/words?flag=search&q=${searchQuery}`,
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
            'url':`{{env('API_URL')}}/words`,
            'method':'POST',
            'data':{
               'word':document.getElementById('word-input').value,
               'translation':document.getElementById('translation-input').value,
               'orderIndex':document.getElementById('index-input').value,
            },
            'timeout':0,
        }).done(function(response){
            var orderIndex = response.data.orderIndex;
           var words = document.getElementsByClassName('words');
           for(key in words)
           {
              if(key < words.length)
              {
              var word = words[key];
              var wordIndex = parseInt(word.getAttribute('data-index'));
              if(wordIndex >= orderIndex)
              {
                 word.setAttribute('data-index',wordIndex+1);
                 word.firstChild.innerHTML = wordIndex+1;
              }

              }
           }
          var word = response.data;
          var tr = document.createElement('TR');
          var td  = document.createElement('TD');
          var index = orderIndex;
          tr.setAttribute('data-index',index);
          tr.className = 'words';
          td.innerHTML = index;
          tr.appendChild(td);
          td = document.createElement('TD');
          td.innerHTML = word.word;
          tr.appendChild(td);
          td = document.createElement('TD');
          td.innerHTML = word.translation;
          tr.appendChild(td);
          td = document.createElement('TD');
          var i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-up text-success mr-2 move-up';
          i.style.fontSize = '30px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          i = document.createElement('I');
          i.className = 'fa fa-arrow-circle-o-down text-danger mr-2 move-down';
          i.style.fontSize = '30px';
          i.setAttribute('data-id',word.id);
          td.appendChild(i);
          tr.appendChild(td);
          var tbody = document.getElementById('tbody-word');
           if(orderIndex <= words.length + 1)
           tbody.insertBefore(tr,tbody.children[orderIndex - 1]);
           if(nextPageUrl != null)
             tbody.lastChild.remove();
           document.getElementById('close-save-modal').click();
        });
    });
</script>
@endsection

@section('css')
   <link rel="stylesheet" href="{{asset('dist/css/word.css')}}">
@endsection
