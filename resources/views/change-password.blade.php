@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Change Password
                    </div>
                    <div class="card-body">
                        {!! Form::open( array('route' => 'update-password','id' => 'cmsForm','class'=>'form-horizontal', 'enctype'=>'multipart/form-data') ) !!}
                            {!! Form::token() !!}
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Existing Password</label>
                                <div class="col-md-8">
                                    {!! Form::input('password','existing_password', null, array('class'=>'form-control', 'id' => 'existing_password','maxlength'=>'20')) !!}
                                    @error('existing_password')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">New Password</label>
                                <div class="col-md-8">
                                    {!! Form::input('password','new_password', null, array('class'=>'form-control', 'id' => 'new_password','maxlength'=>'20')) !!}
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-8">
                                    {!! Form::input('password','confirm_password', null, array('class'=>'form-control', 'id' => 'confirm_password','maxlength'=>'20')) !!}
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert" style="display: inline !important;">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right"></label>
                                <div class="col-md-8">
                                    {!! Form::submit((@$user['user_id']) ? 'Update' : 'Save',['class' => 'btn btn-primary']) !!}
                                    <a href="{{route('profile') }}"><button class="btn btn-danger" type="button">Update Profile</button></a>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection