@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Subscribed To My Jobs
                </div>
                <div class="card-body">
                    <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Status</th>
                                <th>Subscribed At</th>
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
            ajax: "{!! route('list_subscribed_employee') !!}",
            columns: [
                        { data: 'employee_id', name: 'employee_id' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'viewLink', name: 'viewLink' },
                        /*{ data: 'View', name: 'View', render:function(data, type, row){
                            return "<a href='job/"+row.id+"/edit'>Edit</a>"
                        }},*/
                     ]
        });
    });
</script>
@endsection
