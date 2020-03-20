@extends('layouts.app')

@section('content')
@php use App\Helpers\LERHelper; @endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Subscribed To Employers
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable mdl-data-table dataTable" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Employer Name</th>
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
</div>
<script>
    $(document).ready(function() {
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('list_subscribed_employer') !!}",
            columns: [
                        { data: 'employer_id', name: 'employer_id' },
                        { data: 'status', name: 'status' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'viewLink', name: 'viewLink' },
                     ]
        });

        $(document).on('click','.subscribeunsubscribe',function(){
            var EmpId = $(this).data('eid');
            var _url = "{{ route('unsubscribe-job') }}";
            formData = { 
                        "id": EmpId,
                        "_token": "{{ csrf_token() }}",
                       };
            $.ajax({
                url: _url,
                type: "POST",
                data: formData,
                success: function(data){
                    if(data.status == 1){
                        alert("Subscribed successfully ! Hereafter you may get notification if this employer posts any new job");
                        location.reload();
                    } else if(data.status == 2){
                        alert("Illegal Access");
                    } else if(data.status == 3){
                        alert("You have already subscribed to his employer");
                        location.reload();
                    } else if(data.status == 4){
                        alert("You have already unsubscribed to his employer ! Hereafter you may not get notification if this employer posts any new job");
                        location.reload();
                    } else{
                        alert("Some error try after some time !");
                    }
                }
            });
        })
    });
</script>
@endsection
