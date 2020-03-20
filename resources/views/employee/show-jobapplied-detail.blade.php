@extends('layouts.app')

@section('content')
@php
    use App\Helpers\LERHelper;
    $applied = LERHelper::check_job_applied(@$job->id,@Auth::user()->id,@$job->req_id);
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Applied for <a href="{{ route('view-job',array(LERHelper::encryptUrl(@$job->id))) }}"><b>{{ @$job->job_title }}</b></a> - Detail View
                    <a href="{{ route('applied-job') }}" class="btn btn-danger float-right">Back</a> 
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ @$job->job_title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>As a </b>{{ @$job->job_type }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                                <b>Company Name</b> : {{ @$job->organisation_name }}
                                <br>
                                <b>Location</b> : {{ @$job->location }}
                            </h6>
                            <p class="card-text"><b>Must have knowledge on :</b> {{ @$job->job_keywords }}</p>
                            <a href="{{ route('view-job',array(LERHelper::encryptUrl(@$job->id))) }}" class="card-link">More info...</a>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px !important">
                        <div class="card-body">
                            <h5 class="card-title">Job Applied Details</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>Applied on </b>{{ @$check_criteria->created_at }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                                <b>Employer Status</b> :
                                @if(@$check_criteria->employer_seen == 'Seen')
                                    <span class="badge badge-success"> {{ @$check_criteria->employer_seen }}</span>
                                @elseif(@$check_criteria->employer_seen == 'Unseen')
                                    <span class="badge badge-danger">{{ @$check_criteria->employer_seen }}</span>
                                @endif
                                <br>
                                <b>Replied</b> : <a href="#">{{ (@$check_criteria->replied) ? 'Start Chat': 'Not Yet' }}</a>
                            </h6>
                            <p class="card-text">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Job Posted By : </label>
                                    <div class="col-sm-10">
                                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ @$req['first_name'] }} {{ @$req['last_name'] }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Phone No : </label>
                                    <div class="col-sm-10">
                                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ (@$req['mobile_no']) ? @$req['mobile_no'] : '-'  }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Email : </label>
                                    <div class="col-sm-10">
                                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ @$req['user_email'] }}">
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
