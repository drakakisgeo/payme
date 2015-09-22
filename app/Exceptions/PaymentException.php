<?php


namespace App\Exceptions;


use Exception;

class PaymentException extends Exception
{

    /**
     * PaymentException constructor.
     *
     * @param string $string
     */
    public function __construct($string)
    {
      $this->message = $string;
    }



}