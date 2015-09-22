@extends('template')

@section('main')

    <h4 style="padding-top:10px">Welcome <strong>{!! $user->name !!}!</strong> </h4>
<hr>
<div class="panel">
    <div class="panel-body">
        <p>
        <center><i class="glyphicon glyphicon-ok" style="font-size:5em;color:green"></i></center>
        <center><h3 style="color:green">Seems that you don't have any pending payments!</h3></center>
        </p>
    </div>


</div>
@stop