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
                    <b>{{ ucfirst(@$user['first_name']) }} {{ ucfirst(@$user['last_name']) }}</b>, registered as : <b>{{ ucfirst(@$user['role']) }}</b> - Profile</a>
                </div>
                <div class="card-body">
                    <div class="card" style="margin-top: 20px !important">
                        <div class="card-body">
                            <h5 class="card-title">Basic Details</h5>
                            <h6 class="card-subtitle mb-2 text-muted"><b>Account Created on </b>{{ LERHelper::formatDate(@$user->created_at) }}</h6>
                            <h6 class="card-subtitle mb-2 float-right">
                                <b>Chat</b> : <a href="#">Click here to open chat with <b>{{ ucfirst(@$user['first_name']) }} {{ @$user['last_name'] }}</b></a>
                            </h6>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <tr>
                                            <th>First Name: </th>
                                            <td>{{ @$user['first_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Name: </th>
                                            <td>{{ @$user['last_name'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email: </th>
                                            <td>{{ @$user['email'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of birth: </th>
                                            <td>{{ LERHelper::formatDate(@$user->dob) }}</td>
                                        </tr>
                                        @if(@$user['profile_pic'])
                                            <tr>
                                                <th>Profile Pic: </th>
                                                <td>
                                                    <a href="{{ asset('/assets/user/profile_pic') }}/{{ @$user['profile_pic'] }}" target="_blank">
                                                        <img src="{{ asset('/assets/user/profile_pic') }}/{{ @$user['profile_pic'] }}" width="100" height="100">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>Mobile No: </th>
                                            <td>{{ @$user['mobile_no'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Role: </th>
                                            <td>{{ @$user['role'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country: </th>
                                            <td>{{ @$user['state'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>State: </th>
                                            <td>{{ @$user['state'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>City: </th>
                                            <td>{{ @$user['city'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address: </th>
                                            <td>{{ @$user['address'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Logged In: </th>
                                            <td>{{ LERHelper::formatDate(@$user['last_logged_in']) }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Status: </th>
                                            <td><b>{!! (@$user['user_status'] == "Active") ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</b> Since, <span class="badge badge-warning">{{ LERHelper::formatDate(@$user['last_logged_in']) }}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                    @if(@$user['role'] == 'employee')
                        <div class="card" style="margin-top: 20px !important">
                            <div class="card-body">
                                <h5 class="card-title">{{ ucfirst(@$user['role']) }} Details</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Job Seeker</h6>
                                <p class="card-text">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tr>
                                                <th>School Mark: </th>
                                                <td>{{ @$user['schoolmark'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>College Mark: </th>
                                                <td>{{ @$user['collegemark'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Highest Qualification: </th>
                                                <td>{{ @$user['highest_qualification'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Overall Percentage: </th>
                                                <td>{{ @$user['percentage'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Year Passed Out: </th>
                                                <td>{{ @$user['year_passed_out'] }}</td>
                                            </tr>
                                            @if(@$user['resume_doc'])
                                                <tr>
                                                    <th>Resume: </th>
                                                    <td>
                                                        <a href="{{ asset('/assets/user/resume') }}/{{ @$user['resume_doc'] }}" target="_blank">{{ @$user['resume_doc'] }}</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Specialised In: </th>
                                                <td>{{ @$user['specialised_in'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Experience: </th>
                                                <td>{{ @$user['yoe'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Current Salary: </th>
                                                <td>{{ @$user['cur_sal'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Expected Salary: </th>
                                                <td>{{ @$user['exp_sal'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Job Type: </th>
                                                <td>{{ @$user['job_type'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Created At: </th>
                                                <td>{{ LERHelper::formatDate(@$user['created_at']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated At: </th>
                                                <td>{{ LERHelper::formatDate(@$user['updated_at']) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </p>
                            </div>
                        </div>
                    @elseif(@$user['role'] == 'employer')
                        <div class="card" style="margin-top: 20px !important">
                            <div class="card-body">
                                <h5 class="card-title">{{ ucfirst(@$user['role']) }} Details</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Recruiter / Employer</h6>
                                <p class="card-text">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <tr>
                                                <th>Organisation: </th>
                                                <td>{{ @$user['organisation_name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Specialised In: </th>
                                                <td>{{ @$user['specialised_in'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Experience: </th>
                                                <td>{{ @$user['yoe'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Created At: </th>
                                                <td>{{ LERHelper::formatDate(@$user['created_at']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated At: </th>
                                                <td>{{ LERHelper::formatDate(@$user['updated_at']) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </p>
                            </div>
                        </div>
                    @endif
                    <table class="table table-striped table-hover float-right">
                        <tr>
                            <th></th>
                            <td>
                                <a href="{{ URL::to('list-user') }}"><button class="btn btn-primary" type="button">List Users</button></a>
                                @if(@$user['role'] == 'admin')
                                    @if(@$user['user_status'] == "Active")
                                        <a href="{{ route('change-user-status',array('status'=>LERHelper::encryptUrl(2),'id'=>LERHelper::encryptUrl(@$user['id']))) }}">
                                            <button class="btn btn-danger" type="button">Make user Inactive</button>
                                        </a>
                                    @else
                                        <a href="{{ route('change-user-status',array('status'=>LERHelper::encryptUrl(1),'id'=>LERHelper::encryptUrl(@$user['id']))) }}">
                                            <button class="btn btn-success" type="button">Make user Active</button>
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
