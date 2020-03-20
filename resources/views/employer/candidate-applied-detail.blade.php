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
                    <b>{{ ucfirst(@$employee_data['first_name']) }} {{ @$employee_data['last_name'] }}</b> has applied for <a href="{{ route('job.show',array(LERHelper::encryptUrl(@$job_data->id))) }}"><b>{{ @$job_data->job_title }}</b></a>
                    <a href="{{ route('applied-candidate') }}" class="btn btn-danger float-right">Back</a> 
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Job Details</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>As a </b>{{ @$job_data->job_type }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                                <b>Company Name</b> : {{ @$job_data->organisation_name }}
                                <br>
                                <b>Location</b> : {{ @$job_data->location }}
                            </h6>
                            <p class="card-text"><b>Must have knowledge on :</b> {{ @$job_data->job_keywords }}</p>
                            <a href="{{ route('job.show',array(LERHelper::encryptUrl(@$job_data->id))) }}" class="card-link">More info...</a>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px !important">
                        <div class="card-body">
                            <h5 class="card-title">Candidate Details</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>Applied on </b>{{ LERHelper::formatDate(@$job_applied->created_at) }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                                <b>Reply</b> : <a href="{{route('chat.show',array(LERHelper::encryptUrl(@$employee_data['user_id'])))}}">Click here to open chat with <b>{{ ucfirst(@$employee_data['first_name']) }} {{ @$employee_data['last_name'] }}</b></a>
                            </h6>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>Name: </th>
                                            <td>{{ @$employee_data['first_name'] }} {{ @$employee_data['last_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email: </th>
                                            <td>{{ @$employee_data['user_email'] }}</td>
                                        </tr>
                                        @if(@$employee_data['profile_pic'])
                                            <tr>
                                                <th>Profile Pic: </th>
                                                <td>
                                                    <a href="{{ asset('/assets/user/profile_pic') }}/{{ @$employee_data['profile_pic'] }}" target="_blank">
                                                        <img src="{{ asset('/assets/user/profile_pic') }}/{{ @$employee_data['profile_pic'] }}" width="100" height="100">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Mobile No: </th>
                                            <td>{{ @$employee_data['mobile_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Specialised In: </th>
                                            <td>{{ @$employee_data['highest_qualification'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Year of Experience: </th>
                                            <td>{{ @$employee_data['cur_sal'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Minimum Salary: </th>
                                            <td>{{ @$employee_data['exp_sal'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Maximum Salary: </th>
                                            <td>{{ @$employee_data['year_passed_out'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Highest Qualification: </th>
                                            <td>{{ @$employee_data['schoolmark'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>School Percentage: </th>
                                            <td>{{ @$employee_data['schoolmark'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>College Percentage: </th>
                                            <td>{{ @$employee_data['collegemark'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Resume: </th>
                                            <td>
                                                <a href="{{ asset('/assets/user/resume') }}/{{ @$employee_data['resume_doc'] }}" target="_blank">
                                                    {{ @$employee_data['resume_doc'] }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Looking For: </th>
                                            <td>{{ @$employee_data['job_type'] }} Job</td>
                                        </tr>
                                        <tr>
                                            <th>State: </th>
                                            <td>{{ @$employee_data['state'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>City: </th>
                                            <td>{{ @$employee_data['city'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td>{{ @$employee_data['address'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Status: </th>
                                            <td><b>{{ @$employee_data['user_status'] }}</b> Since, <span class="badge badge-warning">{{ LERHelper::formatDate(@$employee_data['last_logged_in']) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td>
                                                <a href="{{ URL::to('job') }}"><button class="btn btn-primary" type="button">Confirm</button></a>
                                                <a href="{{ URL::to('job') }}"><button class="btn btn-danger" type="button">Reject</button></a>
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
