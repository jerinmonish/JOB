@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    List My Jobs
                    <a href="{{route('job.create')}}" class="btn btn-primary float-right">Create Job</a>
                </div>
                <div class="card-body">
                    <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Job Type</th>
                                <th>Joining Time</th>
                                <th>Required Qualification</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('list_active_job') !!}",
            columns: [
                        { data: 'job_title', name: 'job_title' },
                        { data: 'job_type', name: 'job_type' },
                        { data: 'joining_time', name: 'joining_time' },
                        { data: 'req_qualification', name: 'req_qualification' },
                        { data: 'editLink', name: 'editLink' },
                        /*{ data: 'View', name: 'View', render:function(data, type, row){
                            return "<a href='job/"+row.id+"/edit'>Edit</a>"
                        }},*/
                     ]
        });
    });
</script>
@endsection
