<?php

namespace Lollypop\Gateways;

use Braintree_Transaction;
use Exception;
use Illuminate\Http\Request;

class Braintree implements GatewayMethodInterface
{

    public $response;

    public function pay($amount, Request $request)
    {

        $nonce = $request->get('payment_method_nonce');

        $this->response = Braintree_Transaction::sale([
          'amount'             => $amount,
          'paymentMethodNonce' => $nonce
        ]);

        if (!$this->response->success) {
            throw new Exception($this->response->_attributes['message']);
        }

        return;

    }

}