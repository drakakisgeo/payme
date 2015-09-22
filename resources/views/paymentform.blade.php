@extends('template')

@section('main')
    <div class="row">
        <div class="text-center" style="margin-top:50px;margin-bottom:20px;">
            <img src="{{URL::to('/')}}/logo.gif"
                 alt="Lollypop logo">
            <p>
                <small>Online Payments for Lollypop Services like Clicknsend, Billit and more...</small>
            </p>
        </div>
        <div class="well">Lollypop created a special checkout page for you! <strong>Fill in your credit card or choose
                paypal and you're good
                to go!</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h2>Your payment information!</h2>
            <hr>
            This payment is about
            <blockquote>
                {!! $payment->description !!}
            </blockquote>
            <hr>
            Amount to be paid
            <blockquote>
                <div style="font-size:2em;color:green">{!! $payment->amount !!}
                    <span
                            style="font-size:.6em;color:lightgray;font-weight:bold">€</span></div>
            </blockquote>
        </div>
        <div class="col-lg-6">
            <form method="post" action="/checkout/{!! Request::segment(2) !!}" class="form-inline">
                <h2>Payment Form</h2>
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