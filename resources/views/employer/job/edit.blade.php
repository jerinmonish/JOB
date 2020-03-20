@extends('layouts.app')
@section('title','Edit')
@section('content')
    {!! Form::open(array('route' => array('job.update',$job->id),'method'=>'PUT','id' => 'cmsForm','class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

    @include('employer/job/form', ['btn'=>'Update'])
    
    {!! Form::close() !!}
@stop
