<?php

namespace App\Services\Payments;

interface PaymentGatewayInterface
{
    public function processPayment($amount, $currency, $options = []);
}