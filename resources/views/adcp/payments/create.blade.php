@extends('template')

@section('main')
    @include('partials.errors')
    <h2>Create Payment</h2>
    <hr>
    {!! Form::open(['route'=>'adcp.payments.store']) !!}
    <div class="row">
        <div class="col-lg-8">
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('amount','Amount',['class'=>'inline']) !!}
                    {!! Form::text('amount',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('user_id','For Customer') !!}
                    {!! Form::select('user_id',$users,1,['class'=>'form-control']) !!}
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