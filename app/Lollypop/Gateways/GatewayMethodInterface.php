<?php

namespace Lollypop\Gateways;

use Illuminate\Http\Request;

interface GatewayMethodInterface
{

    public function pay($amount, Request $request);

}