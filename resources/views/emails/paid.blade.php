<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Completed</title>
</head>
<body>
<h3>Payment Completed</h3>
<p>We would like to inform you that the payment completed successfully!</p>
<hr>
<p>Amount: <strong>{!! $payment->amount !!} €</strong></p>
<h6>Description</h6>
<p>{!! $payment->description !!}</p>
<p>Best Regards,<br>G.Drakakis</p>
</body>
</html>