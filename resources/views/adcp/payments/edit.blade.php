@extends('template')

@section('main')
    @include('partials.errors')
    <h2>Edit Payment
        <small>[{!! $payment->id !!}]</small>
    </h2>
    <hr>
    {!! Form::model($payment,['route'=>['adcp.payments.update',$payment->id],'method'=>'PUT']) !!}
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
                    {!! Form::label('code','Code',['class'=>'inline']) !!}
                    {!! Form::text('code',null,['disabled','class'=>'form-control']) !!}
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
    <div class="form-group">
        {!! Form::label('active','Is Active?') !!}
        Yes {!! Form::radio('active', 1,$payment->active) !!}
        No {!! Form::radio('active', 0,$payment->active) !!}
    </div>

    {!! Form::submit('Update',['class'=>'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}
    <div class="row">
        <div class="col-lg-8" style="text-align:right">
            <hr>
            {!! Form::open(['route'=>['adcp.payments.destroy',$payment->id],'method'=>'DELETE']) !!}
            In case you want to delete it: {!! Form::submit('DELETE',['class'=>'btn btn-danger btn-sm','data-popmsg'=>'Are you sure?']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('footerjs')
    <script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ck');
        $(document).on("click","*[data-popmsg]",function(e){
            var msg = $(this).attr("data-popmsg");
            if(!confirm(msg))
            {
                e.preventDefault();
            }

        });
    </script>
@stop