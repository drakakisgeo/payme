<!DOCTYPE html>
<html>
    <head>
        <title>{!! trans('ocp.pagetitle') !!}</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="content">
                <div class="title">{!! trans('ocp.pagetitle') !!}</div>
                <p style="color:black;font-weight:strong;font-family:Verdana,Ubuntu,Serif">{!! trans('ocp.authorizedmsg') !!}</p>
                <p><center><script data-type="login" data-redirect-url="{!! URL::to('/') !!}/user/login/callback/?state={!! Clef::generateStateNonce() !!}&amp;amp;next=docs.button_iframe" data-style="flat" data-color="blue" data-app-id="1f6fa703315a975939522de81ed21809" class="clef-button" src="https://clef.io/v3/clef.js" type="text/javascript"></script></center></p>
            </div>
        </div>
    </body>
</html>