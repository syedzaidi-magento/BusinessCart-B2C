<?php

namespace App\Services\Payments;

class GooglePayService implements PaymentGatewayInterface
{
    public function processPayment($amount, $currency, $options = [])
    {
        // Google Pay is primarily client-side; server verifies the payment token
        $paymentToken = $options['payment_token'] ?? null;
        if (!$paymentToken) {
            throw new \Exception('Google Pay requires a payment token.');
        }

        // In a real implementation, you'd use a payment gateway (e.g., Stripe) to process the token
        // For simplicity, we'll simulate success with a mock transaction ID
        // Replace this with actual gateway integration (e.g., Stripe or Braintree)
        return ['transaction_id' => 'GOOGLE-' . uniqid()];
    }
}