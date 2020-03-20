@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Job Applied List</div>
                <div class="card-body">
                    <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Applied For</th>
                                <th>Applied Job On</th>
                                <th>Job Created At</th>
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
            ajax: "{!! route('list_employer_applied_candidate') !!}",
            /*columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric',
            }]*/
            columns: [
                        { data: 'first_name', name: 'first_name' },
                        { data: 'email', name: 'email' },
                        { data: 'mobile_no', name: 'mobile_no' },
                        { data: 'job_title', name: 'job_title' },
                        { data: 'ja_created_at', name: 'ja_created_at' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'viewLink', name: 'viewLink' },
                     ]
        });
    });
</script>
@endsection
