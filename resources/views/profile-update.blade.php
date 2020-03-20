@extends('layouts.app')
@php
    use App\Helpers\LERHelper;
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Profile Update
                    </div>
                    <div class="card-body">
                        {!! Form::open( array('route' => 'update-profile','id' => 'cmsForm','class'=>'form-horizontal', 'enctype'=>'multipart/form-data') ) !!}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">First Name</label>
                                <div class="col-md-3">
                                    {!! Form::text('first_name', @$user['first_name'], array('class'=>'form-control', 'id' => 'first_name','placeholder' => 'Ex: John','maxlength'=>'20')) !!}
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="name" class="col-md-2 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-3">
                                    {!! Form::text('last_name', @$user['last_name'], array('class'=>'form-control', 'id' => 'last_name','placeholder' => 'Ex: Doe','maxlength'=>'20')) !!}
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Email</label>
                                <div class="col-md-3">
                                    {!! Form::text('email', @$user['user_email'], array('class'=>'form-control', 'id' => 'email','placeholder' => 'Ex: johndoe@gmail.com','maxlength'=>'150','disabled'=>'disabled')) !!}
                                    @error('email')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="name" class="col-md-2 col-form-label text-md-right">Profile Pic</label>
                                <div class="col-md-3">
                                    {!! Form::file('profile_pic', array('class'=>'', 'id' => 'profile_pic','accept'=>'image/x-png,image/gif,image/jpeg')) !!}
                                    @error('profile_pic')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-2 img-responsive">
                                    @if(!empty(@$user['profile_pic']))
                                        <a href="{{ asset('/assets/user/profile_pic') }}/{{ @$user['profile_pic'] }}" target="_blank">
                                            <img src="{{ asset('/assets/user/profile_pic') }}/{{ @$user['profile_pic'] }}"class="img-round" width="50" height="50">
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @if(Auth::user()->role == "employee")
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">School Percentage (SSLC/PUC/12th Std)</label>
                                    <div class="col-md-3">
                                        {!! Form::text('schoolmark', @$user['schoolmark'], array('class'=>'form-control', 'id' => 'schoolmark','placeholder' => 'Ex: 70%','maxlength'=>'3')) !!}
                                        @error('schoolmark')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">College Percentage (UG/PG)</label>
                                    <div class="col-md-3">
                                        {!! Form::text('collegemark', @$user['collegemark'], array('class'=>'form-control', 'id' => 'collegemark','placeholder' => 'Ex: 70%','maxlength'=>'3')) !!}
                                        @error('collegemark')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Highest Qualification</label>
                                    <div class="col-md-3">
                                        {!! Form::text('highest_qualification', @$user['highest_qualification'], array('class'=>'form-control', 'id' => 'highest_qualification','placeholder' => 'Ex: Msc (Computer Science), B.Ed','maxlength'=>'150')) !!}
                                        @error('highest_qualification')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Year Passed Out</label>
                                    <div class="col-md-3">
                                         @php
                                            $no_of_yrs = range(date('Y'),1950);
                                         @endphp
                                         {!! Form::select('year_passed_out', $no_of_yrs, null, ['class' => 'form-control']) !!}
                                        @error('year_passed_out')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Overall Studies Percentage</label>
                                    <div class="col-md-3">
                                        {!! Form::text('percentage', @$user['percentage'], array('class'=>'form-control', 'id' => 'percentage','placeholder' => 'Ex: 100%','maxlength'=>'4')) !!}
                                        @error('percentage')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Resume</label>
                                    <div class="col-md-3">
                                        {!! Form::file('resume_doc', array('class'=>'', 'id' => 'resume_doc','accept'=>'.doc,.docx,.txt,.pdf')) !!}
                                        @error('resume_doc')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        @if(!empty(@$user['resume_doc']))
                                            <a href="{{ asset('/assets/user/resume') }}/{{ @$user['resume_doc'] }}" target="_blank" class="btn btn-sm btn-primary">Existing File</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Specialised In</label>
                                    <div class="col-md-3">
                                        {!! Form::text('specialised_in', @$user['specialised_in'], array('class'=>'form-control', 'id' => 'specialised_in','placeholder' => 'Ex: JAVA, PHP, .Net, Python','maxlength'=>'150')) !!}
                                        @error('specialised_in')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Experience</label>
                                    <div class="col-md-3">
                                        {!! Form::text('yoe', @$user['yoe'], array('class'=>'form-control', 'id' => 'yoe','placeholder' => 'Ex: 2 Years','maxlength'=>'10')) !!}
                                        @error('yoe')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Current Salary</label>
                                    <div class="col-md-3">
                                         {!! Form::text('cur_sal', @$user['cur_sal'], array('class'=>'form-control', 'id' => 'cur_sal','placeholder' => 'Ex: 200000','maxlength'=>'150')) !!}
                                        @error('cur_sal')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Expected Salary</label>
                                    <div class="col-md-3">
                                        {!! Form::text('exp_sal', @$user['exp_sal'], array('class'=>'form-control', 'id' => 'exp_sal','placeholder' => 'Ex: 2 500000','maxlength'=>'10')) !!}
                                        @error('exp_sal')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Job Type</label>
                                    <div class="col-md-4">
                                         {!! Form::radio('job_type', 'Full Time', (@$user['job_type'] == "Full Time") ? true : false, array('class'=>'', 'id' => 'job_type')) !!} Full Time
                                         {!! Form::radio('job_type', 'Part Time', (@$user['job_type'] == "Part Time") ? true : false, array('class'=>'', 'id' => 'job_type')) !!} Part Time
                                         {!! Form::radio('job_type', 'Internship', (@$user['job_type'] == "Internship") ? true : false, array('class'=>'', 'id' => 'job_type')) !!} Internship
                                         {!! Form::radio('job_type', 'Freelance', (@$user['job_type'] == "Freelance") ? true : false, array('class'=>'', 'id' => 'job_type')) !!} Freelance
                                        @error('job_type')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @elseif(Auth::user()->role == "employer")
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Organisation Name</label>
                                    <div class="col-md-3">
                                        {!! Form::text('organisation_name', @$user['organisation_name'], array('class'=>'form-control', 'id' => 'organisation_name','placeholder' => 'Ex: Benzy InfoTech','maxlength'=>'150')) !!}
                                        @error('organisation_name')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Specialised In</label>
                                    <div class="col-md-3">
                                        {!! Form::text('specialised_in', @$user['specialised_in'], array('class'=>'form-control', 'id' => 'specialised_in','placeholder' => 'Ex: JAVA, PHP, .Net, Python','maxlength'=>'150')) !!}
                                        @error('specialised_in')
                                            <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label text-md-right">Experience</label>
                                        <div class="col-md-3">
                                            {!! Form::text('yoe', @$user['yoe'], array('class'=>'form-control', 'id' => 'yoe','placeholder' => 'Ex: 2 Years','maxlength'=>'10')) !!}
                                            @error('yoe')
                                                <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Date of Birth</label>
                                <div class="col-md-3">
                                    {!! Form::text('dob', LERHelper::formatMysqlDate(@$user['dob']), array('class'=>'form-control', 'id' => 'dob','placeholder' => 'Ex: 1993-01-01','maxlength'=>'10')) !!}
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="name" class="col-md-2 col-form-label text-md-right">Mobile No</label>
                                <div class="col-md-3">
                                    {!! Form::text('mobile_no', @$user['mobile_no'], array('class'=>'form-control', 'id' => 'mobile_no','placeholder' => 'Ex: 9923456787','maxlength'=>'10')) !!}
                                    @error('mobile_no')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Country</label>
                                <div class="col-md-3">
                                    <select class="form-control setSelect2" id="country" name="country">
                                         @php
                                            $setSelected = '';
                                            foreach ($country as $country_key => $country_value) {
                                        @endphp
                                                <option value="{{ $country_value['id'] }}" <?php if($country_value['id'] == @Auth::user()->country){ ?> selected <?php } ?>>{{ $country_value['country_name'] }}</option>;
                                        @php } @endphp
                                     </select>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <label for="name" class="col-md-2 col-form-label text-md-right">State</label>
                                <div class="col-md-3">
                                    <select class="form-control setSelect2" id="state" name="state">
                                        <option value="{{ @$state['id'] }}">{{ @$state['state_name'] }}</option>
                                     </select>
                                    @error('state')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Address</label>
                                <div class="col-md-5">
                                    {!! Form::textarea('address', @$user['address'], array('class'=>'form-control', 'id' => 'address','placeholder' => 'Ex:  Grit cowork, Silver Palms, 3, Palmgrove Rd, Victoria Layout','maxlength'=>'30')) !!}
                                    @error('address')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right"></label>
                                <div class="col-md-3">
                                    
                                </div>
                                <label for="name" class="col-md-2 col-form-label text-md-right"></label>
                                <div class="col-md-5">
                                    {!! Form::submit((@$user['user_id']) ? 'Update' : 'Save',['class' => 'btn btn-primary']) !!}
                                    <a href="{{ route('change-password') }}"><button class="btn btn-danger" type="button">Change Password</button></a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".setSelect2").select2();

        $("#country").change(function(){
            $("#state").html();
            var _get_state_url = "{{ route('get_state_id') }}";
            formData = { 
                "_token": "{{ csrf_token() }}",
                "country_id": $("#country").val(),
            };
            $.ajax({
                url: _get_state_url,
                type: "POST",
                dataType: "json",
                data: formData,
                success: function(data){
                    var setStateHtml = '';
                    if(data.status == 1){
                        $(data.data).each(function(index,value){
                            setStateHtml += '<option value='+value.id+'>'+value.state_name+'</option>';
                        });
                        $("#state").html(setStateHtml);
                    } else {
                        console.log("error");
                    }
                }
            });
        });
    });
</script>
@endsection