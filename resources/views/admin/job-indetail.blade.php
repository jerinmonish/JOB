@extends('layouts.app')

@section('content')
@php
    use App\Helpers\LERHelper;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Job Detail Page
                    <a href="{{ URL::to('list-jobs') }}" class="btn btn-danger float-right">List Jobs</a>
                </div>
                <div class="card-body">
                    <div class="card" style="margin-top: 20px !important">
                        <div class="card-body">
                            <h5 class="card-title">{{ ucfirst(@$job['job_title']) }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>Job Created on </b>{{ LERHelper::formatDate(@$job->created_at) }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                               Posted By : <b> {{ ucfirst(@$posted['first_name']) }} {{ @$posted['last_name'] }} </b> <a href="#">(Open Chat)</a>
                            </h6>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>Job Title: </th>
                                            <td>{{ @$job['job_title'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Organisation Name: </th>
                                            <td>{{ @$job['organisation_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email: </th>
                                            <td>{{ @$job['req_email'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile No: </th>
                                            <td>{{ @$job['phone_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Keywords: </th>
                                            <td>{{ @$job['job_keywords'] }}</td>
                                        </tr>
                                        @if(@$job['jd_desc'])
                                            <tr>
                                                <th>Job Description File: </th>
                                                <td>
                                                    <a href="{{ asset('/assets/job/jd') }}/{{ @$job['jd_desc'] }}" target="_blank">{{ @$job['jd_desc'] }}</a>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Job Description: </th>
                                            <td>{{ @$job['description'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Type: </th>
                                            <td>{{ @$job['job_type'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Minimum Experience: </th>
                                            <td>{{ @$job['min_exp'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Maximum Experience: </th>
                                            <td>{{ @$job['max_exp'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Required Qualification: </th>
                                            <td>{{ @$job['req_qualification'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Requires Travel: </th>
                                            <td>{{ @$job['req_travel'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Minimum Salary: </th>
                                            <td>{{ @$job['min_sal'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Maximum Salary: </th>
                                            <td>{{ @$job['max_sal'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Applicable for Freshers: </th>
                                            <td>{{ @$job['freshers'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>No Of Positions: </th>
                                            <td>{{ @$job['no_of_pos'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Join As soon as: </th>
                                            <td>{{ @$job['joining_time'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Location: </th>
                                            <td>{{ @$job['location'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start Location: </th>
                                            <td>{{ @$job['location_start'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>End Location: </th>
                                            <td>{{ @$job['location_end'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Status: </th>
                                            <td>{{ @$job['status'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Created At: </th>
                                            <td>{{ @$job['created_at'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job Updated At: </th>
                                            <td>{{ @$job['updated_at'] }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td>
                                                <a href="{{ route('view-iuser',array(LERHelper::encryptUrl(@$job['req_id']))) }}"><button class="btn btn-primary" type="button">View User Profile </button></a>
                                                <a href="{{ URL::to('employer-jobs',array(LERHelper::encryptUrl(@$job['req_id']))) }}"><button class="btn btn-warning" type="button">List all Jobs of {{ ucfirst(@$posted['first_name']) }} {{ @$posted['last_name'] }}</button></a>
                                            </td>
                                        </tr>
                                    </table>
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
