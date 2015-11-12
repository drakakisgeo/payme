@extends('template')
@section('main')
    <h4 style="padding-top:10px">{!! trans('ocp.welcome',['username'=>$user->name]) !!}! </h4>
    <hr>
    <div class="panel">
        <div class="panel-body">
            <p align="center">
                @if($pendingLinks)
                    {{-- Pending payment links --}}
                    <i class="glyphicon glyphicon-alert iconAlert"></i>
            <h4 class="alertHeader">{!! trans('ocp.pending') !!}</h4>
            @else
                {{-- No pending payment links --}}
                <i class="glyphicon glyphicon-ok iconSuccess"></i>
                <h4 class="successHeader">{!! trans('ocp.nopending') !!}</h4>
                @endif
                </p>
        </div>
    </div>
    @if($paymentLinks->count())
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{!! trans('ocp.about') !!}</th>
                <th>{!! trans('ocp.paidat') !!}</th>
                <th>{!! trans('ocp.action') !!}</th>
                <th>{!! trans('ocp.amount') !!}</th>
                <th>{!! trans('ocp.status') !!}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($paymentLinks as $payment)
                <tr>
                    <td>{!! $payment->description !!}</td>
                    <td>{!! $payment->paid_at ? $payment->paid_at->format('d/m/y G:i') : '-' !!}</td>
                    <td>
                        @if(!$payment->paid and $payment->active)
                            <a href="../payment/{{$payment->code}}" target="_blank">{!! trans('ocp.paynow') !!}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{!! $payment->amount !!}
                        <small>{!! trans('ocp.currencysymbol') !!}</small>
                    </td>
                    <td>
                        @if($payment->paid)
                            <span class="success" style="color:green" title="{!! $payment->gatewayref_id !!}"><strong>{!! trans('ocp.paid') !!}</strong></span>
                        @else
                            @if(!$payment->active)
                                <span style="color:darkred;font-weight:bold">{!! trans('ocp.expired') !!}</span>
                            @else
                                -
                            @endif
                        @endif


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $paymentLinks->render() !!}
    @else
        <h4>{!! trans('ocp.noLinksFound') !!}</h4>
    @endif
@stop