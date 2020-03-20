@extends('layouts.app')

@section('content')
@php
    use App\Helpers\LERHelper;
    $applied = LERHelper::check_job_applied(@$job->id,@Auth::user()->id,@$job->req_id);
    $subscribed = LERHelper::check_job_subscribed(@Auth::user()->id,@$job->req_id);
    $jobC = LERHelper::jobViewCount(@$job->id);
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>{{ @$job->job_title }}</b> - Detail View
                    <a href="{{ route('jobs') }}" class="btn btn-primary float-right">List Jobs</a>
                </div>
                <div class="card-body">
                    @if($job)
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <span style="color: white">
                                    <b>Organisation: {{ @$job->organisation_name }}, Contact Email: {{ @$job->req_email }}</b>
                                </span>
                                <span style="color: white" class="float-right">
                                    {!! @$jobC !!}
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title float-right">
                                    <p>Job Location: {{ @$job->location }}</p>
                                    <p>Job Posted On: {{ @date('d-m-Y',strtotime($job->created_at)) }}</p>
                                </h5>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Job Title:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->job_title }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Job Description:</label>
                                    <div class="col-sm-8">
                                        <b><span class="form-control-plaintext">{{ @$job->description }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Must have knowledge on:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->job_keywords }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Job Type:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->job_type }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Minimum Experience:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->min_exp }} Years</span></b>
                                    </div>
                                    <label for="staticEmail" class="col-md-2 col-form-label">Maximum Experience:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->max_exp }} Years</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Required Qualification:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->req_qualification }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Required Travel:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->req_travel }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Minimum Salary:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->min_sal }}</span></b>
                                    </div>
                                    <label for="staticEmail" class="col-md-2 col-form-label">Maximum Salary:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->max_sal }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Applicable to freshers:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->freshers }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">No Of Positions:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->no_of_pos }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Contact No:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->phone_no }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-md-2 col-form-label">Joining Period:</label>
                                    <div class="col-sm-4">
                                        <b><span class="form-control-plaintext">{{ @$job->joining_time }}</span></b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right"></label>
                                    <div class="col-md-3"></div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right"></label>
                                    <div class="col-md-5">
                                        @if(!empty(@$applied['data']['id']))
                                            <a href="{{ route('detail-applied-job',array(LERHelper::encryptUrl(@$applied['data']['id']))) }}" class="btn btn-info">Already Applied</a>
                                        @else
                                            <a href="{{ route('apply-job',array(LERHelper::encryptUrl(@$job->id))) }}" class="btn btn-success">Apply</a>
                                        @endif
                                        @if(empty(@$subscribed['data']['id']))
                                            <button type="button" class="btn btn-warning job_subscribing" data-value="Subscribe" id="subscribe_employer">Subscribe</button>
                                        @else
                                            <button type="button" class="btn btn-danger job_subscribing" data-value="UnSubscribe" id="unsubscribe_employer" data-delId="{{ LERHelper::encryptUrl(@$subscribed['data']['id']) }}">UnSubscribe</button>
                                        @endif
                                        <span id="cmnBtnSubUnsub" data-idsr="{{ LERHelper::encryptUrl(@$job->req_id) }}" style="display: none;"></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer bg-secondary">
                                <b>
                                    <p class="card-text" style="color: white">Note: Kindly check your criteria and Apply for this job !.</p>
                                </b>
                            </div>
                        </div>
                    @else
                        <p class="alert alert-danger">
                            Some error while check for JOB !
                            <a href="{{ route('jobs') }}" style="color: black">Back to List Jobs</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", ".job_subscribing", function() {
            var status = $(this).data('value');
            var delId = $("#unsubscribe_employer").attr('data-delId');
            var employer_id = $("#cmnBtnSubUnsub").data('idsr');
            var _url = "";
            var subBtn = '<button type="button" class="btn btn-warning job_subscribing" data-value="Subscribe" id="subscribe_employer">Subscribe</a>';
            var unsubBtn = '';
            console.log(delId);
            if(status == "Subscribe"){
                var _url = "{{ route('subscribe-job') }}";
                formData = { 
                            "employer_id" : employer_id,
                            "_token": "{{ csrf_token() }}",
                           };
            } else if(status == "UnSubscribe"){
                var _url = "{{ route('unsubscribe-job') }}";
                formData = { 
                            "employer_id" : employer_id,
                            "id": delId,
                            "_token": "{{ csrf_token() }}",
                           };
            }

            // console.log(formData);
            $.ajax({
                url: _url,
                type: "POST",
                data: formData,
                success: function(data){
                    console.log(data.status);
                    if(data.status == 1){
                        $("#subscribe_employer").hide();
                        console.log(data.del_id);
                        unsubBtn = '<button type="button" class="btn btn-danger job_subscribing" data-delId="'+data.del_id+'" data-value="UnSubscribe" id="unsubscribe_employer">UnSubscribe</a>';
                        $("#cmnBtnSubUnsub").show().html(unsubBtn);
                        alert("Subscribed successfully ! Hereafter you may get notification if this employer posts any new job");
                    } else if(data.status == 2){
                        alert("Illegal Access");
                    } else if(data.status == 3){
                        alert("You have already subscribed to his employer");
                    } else if(data.status == 4){
                        $("#unsubscribe_employer").hide();
                        $("#cmnBtnSubUnsub").show().html(subBtn);
                        alert("You have already unsubscribed to his employer ! Hereafter you may not get notification if this employer posts any new job");
                    } else{
                        alert("Some error try after some time !");
                    }
                }
            });
        });
    })
</script>
@endsection
