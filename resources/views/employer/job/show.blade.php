@php
    use App\Helpers\LERHelper;
    $jobC = LERHelper::jobViewCount(@$job->id);
@endphp
@extends('layouts.app')
@section('title','View Job')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ @$job->job_title }} - View Job
                    <a href="{{route('list-active-jobs')}}" class="btn btn-primary float-right">List Job</a>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form_validation">
                        {!! Form::token() !!}
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Title</b>
                            <div class="col-md-6">
                               {{ @$job->job_title }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Organisation Name</b>
                            <div class="col-md-6">
                                {{ @$job->organisation_name }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Type</b>
                            <div class="col-md-6">
                                {{ @$job->job_type }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Minimum Experience</b>
                            <div class="col-md-6">
                                {{ @$job->min_exp }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Maximum Experience</b>
                            <div class="col-md-6">
                                {{ @$job->max_exp }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Required Qualification</b>
                            <div class="col-md-6">
                                {{ @$job->req_qualification }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Required Travel</b>
                            <div class="col-md-6">
                                {{ @$job->req_travel }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Minimum salary</b>
                            <div class="col-md-6">
                                {{ @$job->min_sal }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Maximum salary</b>
                            <div class="col-md-6">
                                {{ @$job->max_sal }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Applicable to Freshers ?</b>
                            <div class="col-md-6">
                                {{ @$job->freshers }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Description</b>
                            <div class="col-md-6">
                                {{ @$job->description }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">No Of Positions</b>
                            <div class="col-md-6">
                                {{ @$job->no_of_pos }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Contact Person Email</b>
                            <div class="col-md-6">
                                {{ @$job->req_email }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Phone Number</b>
                            <div class="col-md-6">
                                {{ @$job->phone_no }}
                            </div>
                        </div>
                        @if(!empty($job->jd_desc))
	                        <div class="form-group row">
	                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Description File</b>
	                            <div class="col-md-6">
	                                <a href="{{ asset('/assets/job/jd') }}/{{ $job->jd_desc }}" target="_blank">View {{ $job->jd_desc }}</a>
	                            </div>
	                        </div>
                        @endif
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Joining Time</b>
                            <div class="col-md-6">
                                {{ @$job->joining_time }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Keywords</b>
                            <div class="col-md-6">
                                {{ @$job->job_keywords }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Location</b>
                            <div class="col-md-6">
                                {{ @$job->location }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Location Latitude</b>
                            <div class="col-md-6">
                                {{ @$job->location_start }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Location Longitude</b>
                            <div class="col-md-6">
                                {{ @$job->location_end }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Status</b>
                            <div class="col-md-6">
                                {{ @$job->status }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right">Job Views</b>
                            <div class="col-md-6">
                                {!! @$jobC !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <b for="name" class="col-md-4 col-form-label text-md-right"></b>
                            <div class="col-lg-offset-2 col-md-7">
                                <a href="{{ URL::to('job') }}"><button class="btn btn-danger" type="button">List Jobs</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
