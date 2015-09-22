@extends('template')

@section('main')
    @include('partials.errors')
    <h2>Create a client</h2>
    <hr>
    {!! Form::open(['route'=>'adcp.users.store']) !!}
    <div class="row">
        <div class="col-lg-8">
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('name','Name',['class'=>'inline']) !!}
                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('email','Email') !!}
                    {!! Form::text('email',null,['class'=>'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                {!! Form::label('description','Description') !!}
                {!! Form::textarea('description',null,['class'=>'form-control','id'=>'ck']) !!}
            </div>
        </div>
    </div>
    {!! Form::submit('Create',['class'=>'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}
@stop

@section('footerjs')
    <script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ck' );
    </script>
@stop