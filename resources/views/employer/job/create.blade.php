@extends('layouts.app')
@section('title','Job')
@section('content')
    {!! Form::open( array('route' => 'job.store','id' => 'cmsForm','class'=>'form-horizontal', 'enctype'=>'multipart/form-data') ) !!}
	
  		@include('employer/job/form', ['btn'=>'Save'])
  	
    {!! Form::close() !!}
@stop
