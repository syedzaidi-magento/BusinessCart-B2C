<?php

namespace App\Services\Payments;

use AmazonPay\Client;

class AmazonPayService implements PaymentGatewayInterface
{
    protected $client;

    public function __construct()
    {
        $config = [
            'merchant_id' => Configuration::getConfigValue('payment_method_amazon_merchant_id'),
            'access_key' => Configuration::getConfigValue('payment_method_amazon_access_key'),
            'secret_key' => Configuration::getConfigValue('payment_method_amazon_secret_key'),
            'region' => 'us', // Adjust based on your region
            'sandbox' => true, // Use sandbox for testing
        ];
        $this->client = new Client($config);
    }

    public function processPayment($amount, $currency, $options = [])
    {
        $orderReferenceId = $options['order_reference_id'] ?? null;
        if (!$orderReferenceId) {
            throw new \Exception('Amazon Pay requires an order reference ID.');
        }

        $response = $this->client->setOrderReferenceDetails([
            'amazon_order_reference_id' => $orderReferenceId,
            'amount' => $amount,
            'currency_code' => $currency,
            'seller_order_id' => $options['order_id'] ?? null,
        ]);

        if ($response->isSuccess()) {
            $confirmResponse = $this->client->confirmOrderReference([
                'amazon_order_reference_id' => $orderReferenceId,
            ]);

            if ($confirmResponse->isSuccess()) {
                $authorizeResponse = $this->client->authorize([
                    'amazon_order_reference_id' => $orderReferenceId,
                    'authorization_reference_id' => uniqid('AUTH-'),
                    'amount' => $amount,
                    'currency_code' => $currency,
                    'capture_now' => true, // Capture immediately
                ]);

                if ($authorizeResponse->isSuccess()) {
                    return ['transaction_id' => $authorizeResponse->toArray()['AuthorizeResult']['AuthorizationDetails']['AmazonAuthorizationId']];
                }
            }
        }

        throw new \Exception('Amazon Pay transaction failed: ' . ($response->toArray()['Error']['Message'] ?? 'Unknown error'));
    }
}