<?php

namespace App\Services\Payments;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePayService implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(Configuration::getConfigValue('payment_method_stripe_secret_key'));
    }

    public function processPayment($amount, $currency, $options = [])
    {
        $paymentIntent = PaymentIntent::create([
            'amount' => (int) ($amount * 100), // Convert to cents
            'currency' => strtolower($currency),
            'payment_method' => $options['payment_method_id'],
            'confirmation_method' => 'manual',
            'confirm' => true,
            'capture_method' => 'automatic',
        ]);

        if ($paymentIntent->status === 'succeeded') {
            return ['transaction_id' => $paymentIntent->id];
        }

        throw new \Exception('Stripe payment failed: ' . ($paymentIntent->last_payment_error->message ?? 'Unknown error'));
    }
}