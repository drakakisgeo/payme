<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{!! trans('ocp.mailtitle') !!}</title>
</head>
<body>
<h3>{!! trans('ocp.mailresult') !!}</h3>
<p>{!! trans('ocp.mailbody') !!}</p>
<hr>
<p>{!! trans('ocp.mailamount') !!}: <strong>{!! $payment->amount !!} {!! trans('ocp.currencysymbol') !!}</strong></p>
<h6>{!! trans('ocp.maildescription') !!}</h6>
<p>{!! $payment->description !!}</p>
<p>{!! trans('ocp.mailsign') !!}<br>{!! trans('ocp.mailsignname') !!}</p>
</body>
</html>