@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List All Jobs</div>
                <div class="card-body">
                    <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Organisation Name</th>
                                <th>Organisation Email</th>
                                <th>Organisation Phone No</th>
                                <th>Job Created On</th>
                                <th>Status</th>
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
            ajax: "{!! route('list_all_job') !!}",
            /*columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric',
            }]*/
            columns: [
                        { data: 'job_title', name: 'job_title' },
                        { data: 'organisation_name', name: 'organisation_name' },
                        { data: 'req_email', name: 'req_email' },
                        { data: 'phone_no', name: 'phone_no' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'status', name: 'status' },
                        { data: 'viewLink', name: 'viewLink'},
                     ]
        });
    });
</script>
@endsection
