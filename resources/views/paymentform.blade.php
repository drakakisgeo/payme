@extends('template')

@section('main')
    @include('partials.errors')
    <div class="row">
        <div class="text-center" style="margin-top:50px;margin-bottom:20px;">
            <img src="{{URL::to('/')}}/logo.gif" alt="Lollypop logo">
            <p>
                <small>{!! trans('ocp.aboutapp') !!}</small>
            </p>
        </div>
        <div class="well">{!! trans('ocp.explanation') !!}</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h2>{!! trans('ocp.paymenth2') !!}</h2>
            <hr>
            {!! trans('ocp.aboutpayment') !!}
            <blockquote>
                {!! $payment->description !!}
            </blockquote>
            <hr>
            {!! trans('ocp.amounttobepaid') !!}
            <blockquote>
                <div style="font-size:2em;color:green">{!! $payment->amount !!}
                    <span
                            style="font-size:.6em;color:lightgray;font-weight:bold">€</span></div>
            </blockquote>
        </div>
        <div class="col-lg-6">
            <form method="post" action="/checkout/{!! Request::segment(2) !!}" class="form-inline">
                <h2>{!! trans('ocp.formtitle') !!}</h2>
                <hr>
                <div id="dropin-container"></div>
                <br>
                <input type="submit" value="Pay now!" class="btn btn-success btn-lg">
            </form>
        </div>
    </div>

@stop

@section('footerjs')
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    <script>
        braintree.setup("<?php echo Braintree_ClientToken::generate(); ?>", "dropin", {
            container: "dropin-container"
        });
    </script>
@stop