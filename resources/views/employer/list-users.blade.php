@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
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
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Specialised In</th>
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
            ajax: "{!! route('list_active_user') !!}",
            /*columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric',
            }]*/
            columns: [
                        { data: 'first_name', name: 'first_name' },
                        { data: 'last_name', name: 'last_name' },
                        { data: 'email', name: 'email' },
                        { data: 'specialised_in', name: 'specialised_in' },
                        { data: 'viewLink', name: 'viewLink'},
                     ]
        });
    });
</script>
@endsection
