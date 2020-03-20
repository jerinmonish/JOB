@extends('layouts.app')

@section('content')
@php
    use App\Helpers\LERHelper;
    $subjectData = isset($job_regarding['job_name']) ? 'Regarding '.@$job_regarding['job_name']: 'Regarding Job';
    $jobidData = isset($job_regarding['job_id']) ? LERHelper::encryptUrl(@$job_regarding['job_id']): '';
@endphp
<style>
  .darker{
    text-align:right !important;
  }
  .scrollSetter{
    /*max-height: 600px;
    overflow-y: auto;*/
    position:relative;
    height:600px;
  }
  #messagewindow, #inputcontainer{
    position:absolute;
    left:0;
    right:0;
    /*border:1px solid #000;*/
}
#messagewindow{   
    overflow:auto;
    top:0;
    bottom:3em;
}
</style>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
          <div class="card-header">
            Chatting With <b>{{ LERHelper::getFullName(LERHelper::decryptUrl($id)) }}</b>
            <a href="#" class="btn btn-danger float-right" onclick="history.back()">Back</a> 
          </div>
        <div class="scrollSetter">
        <div id="messagewindow">
          @if(isset($my_chat) && count($my_chat) > 0)
            @foreach($my_chat as $my_key => $my_message)
              
                <div class="card-body mt-4 @if(LERHelper::decryptUrl($id) == $my_message->to_id) darker @else light @endif mainMsgClass">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        @if(@Auth::user()->id == $my_message->from_id)
                          {{ LERHelper::getFullName($my_message->from_id) }}
                          <img src="{{ asset('/assets/user/profile_pic') }}/{{ @Auth::user()->profile_pic }}" width="50" height="50" class="rounded-circle">
                        @else
                          <img src="{{ asset('/assets/user/profile_pic') }}/{{ @$otherprofile->profile_pic }}" width="50" height="50" class="rounded-circle">
                          {{ LERHelper::getFullName($my_message->from_id) }}
                        @endif
                        <span class="small text-muted @if(LERHelper::decryptUrl($id) == $my_message->to_id) pull-left @else pull-right @endif">
                          {{ LERHelper::manuFormatDate($my_message->created_at) }}
                        </span>
                      </h5>
                      <!-- <h6 class="card-subtitle mb-2 text-muted"><b></b></h6> -->
                      <p class="card-text">
                        <b>
                          {{ $my_message->msgdata }}
                        </b>
                      </p>
                    </div>
                  </div>
                </div>
            @endforeach
          @else
            <div class="card-body mt-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title" style="text-align: center;">Hi, {{ @Auth::user()->first_name.' '.@Auth::user()->last_name }}<span class="small text-muted pull-right">{{ date('d-m-Y') }}</span></h5>
                  <!-- <h6 class="card-subtitle mb-2 text-muted"><b></b></h6> -->
                  <p class="card-text">
                    <b>Not Yet Chated !</b>
                  </p>
                </div>
              </div>
            </div>
          @endif
          <span id="justNow"></span>
        </div>
        </div>
          <div class="card-body">
            <div class="card">
              <div class="row">
                <div class="col-sm-10" style="top: 10px !important">
                  <span id="userTypingSpan" class="text-muted"></span>
                  {!! Form::text('subject', @$subjectData, array('class'=>'form-control', 'id' => 'subject','placeholder' => 'Enter Subject','maxlength'=>'20','rows'=>'5','data-jid'=>@$jobidData,'required'=>'required','style'=>'display:none')) !!}
                  <br>
                  {!! Form::textarea('description', null, array('class'=>'form-control', 'id' => 'description','placeholder' => 'Type Message Here','maxlength'=>'500','rows'=>'5','required'=>'required')) !!}
                </div>
                <div class="col-sm-2" style="top: 65px !important;">
                  <button type="button" class="btn btn-primary" id="sendFrm">Send</button>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#messagewindow').animate({
      scrollTop: $('#messagewindow')[0].scrollHeight
    }, 2000);

    $("#sendFrm").click(function() {
      var _url = "{{ route('chat.store') }}";
      formData = { 
        "to_id" : "{{ $id }}",
        "msg" : $("#description").val(),
        "sub" : $("#subject").val(),
        "_token": "{{ csrf_token() }}",
      };
      if($("#description").val() != ''){
        $.ajax({
          url: _url,
          type: "POST",
          data: formData,
            success: function(data){
              // console.log(data);
              var rtnContent = '';
              if(data.status == 1 && data.message =="Success"){
                $("#description").val("");
                rtnContent = '<div class="card-body mt-4 darker"><div class="card"><div class="card-body"><h5 class="card-title">'+data.data.user_name+'<img src="'+data.data.prof_pic+'" width="50" height="50" class="rounded-circle"><span class="small text-muted pull-left">'+data.data.msg_at+'</span></h5><p class="card-text"><b>'+data.data.msgdata+'</b></p></div></div></div>';
                $(".mainMsgClass").append(rtnContent);
              } else if(data.status == 0 && data.message =="Error"){
                alert("Error sending Message");
              } else {
                alert("Server Error");
              }
          }
        });
      } else {
        alert("Enter Message");
      }
    });

    /*$("#description").on('keyup',function(){
      var _Uurl = "{{ route('user_typing') }}";
      formData2 = { 
        "_token": "{{ csrf_token() }}",
        "userId": "{{ LERHelper::encryptUrl(@Auth::user()->id) }}",
        "userName": "{{ LERHelper::getFullName(@Auth::user()->id) }}",
        "to_id" : "{{ $id }}",
      };
      $.ajax({
          url: _Uurl,
          type: "POST",
          data: formData2,
            success: function(data){
              //console.log(data);
          }
        });
    });*/
  });
</script>
@endsection
