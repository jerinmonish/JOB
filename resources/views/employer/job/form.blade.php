<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Add Job
                    <a href="{{route('list-active-jobs')}}" class="btn btn-primary float-right">List Job</a>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form_validation">
                        {!! Form::token() !!}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Title</label>
                            <div class="col-md-6">
                                {!! Form::text('job_title', @$job->job_title, array('class'=>'form-control', 'id' => 'job_title','placeholder' => 'Ex: Software Engineer','maxlength'=>'100')) !!}
                                @error('job_title')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Organisation Name</label>
                            <div class="col-md-6">
                                {!! Form::text('organisation_name', (@$job->organisation_name) ? @$job->organisation_name : @Auth::user()->organisation_name, array('class'=>'form-control', 'id' => 'organisation_name','placeholder' => 'Ex: Infosys Tech Ltd','maxlength'=>'100')) !!}
                                @error('organisation_name')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Type</label>
                            <div class="col-md-6">
                                <input name="job_type" type="radio" id="radio_3" value="Full-Time" <?php if(@$job->job_type == 'Full-Time' ){ echo 'checked';} ?> checked="checked" />
                                <label for="radio_3">Full Time</label>

                                <input name="job_type" type="radio" id="radio_4" value="Part-Time" <?php if(@$job->job_type == 'Part-Time' ){ echo 'checked';} ?> />
                                <label for="radio_4">Part Time</label>

                                <input name="job_type" type="radio" id="radio_5" value="Freelancer" <?php if(@$job->job_type == 'Freelancer' ){ echo 'checked';} ?> />
                                <label for="radio_5">Freelancer</label>

                                <input name="job_type" type="radio" id="radio_6" value="Internship" <?php if(@$job->job_type == 'Internship' ){ echo 'checked';} ?> />
                                <label for="radio_6">Internship</label>
                                @if ($errors->has('job_type'))
                                    <span class="help-block" style="display: inline !important;">
                                        <strong>{{ $errors->first('job_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Minimum Experience</label>
                            <div class="col-md-6">
                                {!! Form::text('min_exp', @$job->min_exp, array('class'=>'form-control', 'id' => 'min_exp','placeholder' => 'Ex: 02 Years','maxlength'=>'20')) !!}
                                @error('min_exp')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Maximum Experience</label>
                            <div class="col-md-6">
                                {!! Form::text('max_exp', @$job->max_exp, array('class'=>'form-control', 'id' => 'max_exp','placeholder' => 'Ex: 10 Years','maxlength'=>'20')) !!}
                                @error('max_exp')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Required Qualification</label>
                            <div class="col-md-6">
                                {!! Form::text('req_qualification', @$job->req_qualification, array('class'=>'form-control', 'id' => 'req_qualification','placeholder' => 'Ex: MCA, CS','maxlength'=>'50')) !!}
                                @error('req_qualification')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Required Travel</label>
                            <div class="col-md-6">
                                <input name="req_travel" type="radio" id="radio_3" value="Yes" <?php if(@$job->req_travel == 'Yes' ){ echo 'checked';} ?> checked="checked" />
                                <label for="radio_3">Yes</label>

                                <input name="req_travel" type="radio" id="radio_4" value="No" <?php if(@$job->req_travel == 'No' ){ echo 'checked';} ?> />
                                <label for="radio_4">No</label>
                                @if ($errors->has('req_travel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('req_travel') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Minimum salary</label>
                            <div class="col-md-6">
                                {!! Form::text('min_sal', @$job->min_sal, array('class'=>'form-control', 'id' => 'min_sal','placeholder' => 'Ex: 10000.00','maxlength'=>'10')) !!}
                                @error('min_sal')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Maximum salary</label>
                            <div class="col-md-6">
                                {!! Form::text('max_sal', @$job->max_sal, array('class'=>'form-control', 'id' => 'max_sal','placeholder' => 'Ex: 90000.50','maxlength'=>'10')) !!}
                                @error('max_sal')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Applicable to Freshers ?</label>
                            <div class="col-md-6">
                                <input name="freshers" type="radio" id="radio_3" value="Yes" <?php if(@$job->freshers == 'Yes' ){ echo 'checked';} ?> />
                                <label for="radio_3">Yes</label>

                                <input name="freshers" type="radio" id="radio_4" value="No" <?php if(@$job->freshers == 'No' ){ echo 'checked';} ?> checked="checked" />
                                <label for="radio_4">No</label>
                                @if ($errors->has('freshers'))
                                    <span class="help-block" style="display: inline !important;">
                                        <strong>{{ $errors->first('freshers') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Description</label>
                            <div class="col-md-6">
                                {!! Form::textarea('description', @$job->description, array('class'=>'form-control', 'id' => 'description','placeholder' => 'Job Description','maxlength'=>'500')) !!}
                                @error('description')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">No Of Positions</label>
                            <div class="col-md-6">
                                {!! Form::text('no_of_pos', @$job->no_of_pos, array('class'=>'form-control', 'id' => 'no_of_pos','placeholder' => 'Ex: 5','maxlength'=>'3')) !!}
                                @error('no_of_pos')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Contact Person Email</label>
                            <div class="col-md-6">
                                {!! Form::text('req_email', (@$job->req_email) ? @$job->req_email : @Auth::user()->email, array('class'=>'form-control', 'id' => 'req_email','placeholder' => 'Ex: jobs@gmail.com','maxlength'=>'50')) !!}
                                @error('req_email')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                            <div class="col-md-6">
                                {!! Form::text('phone_no', @$job->phone_no, array('class'=>'form-control', 'id' => 'phone_no','placeholder' => 'Ex: 9987654321','maxlength'=>'10')) !!}
                                @error('phone_no')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Description File</label>
                            <div class="col-md-4">
                                {!! Form::file('jd_desc', array('class'=>'form-control', 'id' => 'jd_desc')) !!}
                                {!! Form::hidden('existing_jd_desc', @$job->jd_desc, array('class'=>'form-control')) !!}
                                @error('jd_desc')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                @if(!empty($job->jd_desc))
                                    <a href="{{ asset('/assets/job/jd') }}/{{ $job->jd_desc }}" target="_blank" class="btn btn-sm btn-primary">View Existing File</a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Joining Time</label>
                            <div class="col-md-6">
                                <input name="joining_time" type="radio" id="radio_3" value="Immediate" <?php if(@$job->joining_time == 'Immediate' ){ echo 'checked';} ?> checked="checked" />
                                <label for="radio_3">Immediate</label>

                                <input name="joining_time" type="radio" id="radio_4" value="30-Days" <?php if(@$job->joining_time == '30-Days' ){ echo 'checked';} ?> />
                                <label for="radio_4">30-Days</label>

                                <input name="joining_time" type="radio" id="radio_5" value="60-Days" <?php if(@$job->joining_time == '60-Days' ){ echo 'checked';} ?> />
                                <label for="radio_5">60-Days</label>

                                <input name="joining_time" type="radio" id="radio_6" value="90-Days" <?php if(@$job->joining_time == '90-Days' ){ echo 'checked';} ?> />
                                <label for="radio_6">90-Days</label>
                                @if ($errors->has('joining_time'))
                                    <span class="help-block" style="display: inline !important;">
                                        <strong>{{ $errors->first('joining_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Keywords</label>
                            <?php
                                $exp = explode(",", @$job->job_keywords);
                            ?>
                            <div class="col-md-6">
                                <select id="job_keywords" name="job_keywords[]" class="form-control" multiple="multiple">
                                    <option value="">Choose an item</option>
                                    @if(!empty($tag_data))
                                        @foreach(json_decode($tag_data) as $tag)
                                            <option value="{{ $tag->id }}" @php if(in_array($tag->id,$exp)) { @endphp selected @php } @endphp>{{ $tag->tag_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('job_keywords')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Location</label>
                            <div class="col-md-6">
                                {!! Form::text('location', @$job->location, array('class'=>'form-control', 'id' => 'location','placeholder' => 'Ex: Bangalore, Chennai','maxlength'=>'50')) !!}
                                @error('location')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Location Latitude</label>
                            <div class="col-md-6">
                                {!! Form::text('location_start', @$job->location_start, array('class'=>'form-control', 'id' => 'location_start','placeholder' => 'Ex: +9812222.00','maxlength'=>'50')) !!}
                                @error('location_start')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Location Longitude</label>
                            <div class="col-md-6">
                                {!! Form::text('location_end', @$job->location_end, array('class'=>'form-control', 'id' => 'location_end','placeholder' => 'Ex: -90111111.90','maxlength'=>'50')) !!}
                                @error('location_end')
                                    <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Job Status</label>
                            <div class="col-md-6">
                                <input name="status" type="radio" id="radio_3" value="Active" <?php if(@$job->status == 'Active' ){ echo 'checked';} ?> checked="checked" />
                                <label for="radio_3">Active</label>

                                <input name="status" type="radio" id="radio_4" value="Inactive" <?php if(@$job->status == 'Inactive' ){ echo 'checked';} ?> />
                                <label for="radio_4">Inactive</label>
                                @if ($errors->has('status'))
                                    <span class="help-block" style="display: inline !important;">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-lg-offset-2 col-md-7">
                                {!! Form::submit((@$job->id) ? 'Update' : 'Save',['class' => 'btn btn-primary']) !!}
                                <a href="{{ URL::to('job') }}"><button class="btn btn-danger" type="button">Cancel</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#job_keywords").select2();
    });
</script>