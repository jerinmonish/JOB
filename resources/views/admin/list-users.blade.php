@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List All User - Dashboard</div>
                <div class="card-body">
                    <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Account Created On</th>
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
            ajax: "{!! route('list_user') !!}",
            /*columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric',
            }]*/
            columns: [
                        { data: 'full_name', name: 'full_name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'user_status', name: 'user_status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'viewLink', name: 'viewLink'},
                     ]
        });
    });
</script>
@endsection
