@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Applied Jobs
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Contact No</th>
                                    <th>Contact Email</th>
                                    <th>Job Created On</th>
                                    <th>Job Applied On</th>
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
</div>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('listAllAppliedJobs') !!}",
            columns: [
                        { data: 'job_title', name: 'job_title' },
                        { data: 'phone_no', name: 'phone_no' },
                        { data: 'req_email', name: 'req_email' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'ja_created_at', name: 'ja_created_at' },
                        { data: 'viewLink', name: 'viewLink' },
                        /*{ data: 'View', name: 'View', render:function(data, type, row){
                            return "<a href='job/"+row.id+"/edit'>Edit</a>"
                        }},*/
                     ]
        });
    });
</script>
@endsection
