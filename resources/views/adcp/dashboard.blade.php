@extends('template')

@section('main')
    <div class="row">
        <div class="col-lg-8">
            <h2>Dashboard
                <small>{{Auth::user()->name}} is on board!</small>
            </h2>
        </div>
        <div class="col-lg-4" style="padding-top:25px;text-align:right">
            <a href="{{URL::route('adcp.payments.create')}}">[+] Add new</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>CODE</th>
                <th><a href="{!! URL::route('adcp.users.index') !!}">CLIENT</a> <small><a href="{!! URL::route('adcp.users.create') !!}">[+]</a></small></th>
                <th>ABOUT</th>
                <th>AMOUNT</th>
                <th>CREATED</th>
                <th>PAID</th>
                <th>ACTIONS</th>
                <th>STATUS</th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{!! $payment->code !!}</td>
                    <td>{!! $payment->user->name !!}</td>
                    <td>{!! $payment->description !!}</td>
                    <td>{!! $payment->amount !!}
                        <small>€</small>
                    </td>
                    <td>{!! $payment->created_at->format('d/m/Y -- G:i') !!}</td>
                    <td>{!! $payment->paid_at ? $payment->paid_at->format('d/m/Y -- G:i') : '-' !!}</td>
                    <td>
                        @if(!$payment->paid)
                            <a href="../payment/{{$payment->code}}" target="_blank">Open</a> | <a
                                    href="{{ URL::route('adcp.payments.edit',$payment->id) }}">Edit</a>
                        @endif
                    </td>
                    <td>
                        @if($payment->paid)
                            <span class="success" style="color:green" title="{!! $payment->gatewayref_id !!}"><strong>PAID</strong></span>
                        @else
                            -
                        @endif


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $payments->render() !!}
    </div>
@stop