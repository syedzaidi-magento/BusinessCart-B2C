<?php

namespace App\Services\Payments;

class PurchaseOrderService implements PaymentGatewayInterface
{
    public function processPayment($amount, $currency, $options = [])
    {
        $poNumber = $options['po_number'] ?? null;
        if (!$poNumber) {
            throw new \Exception('Purchase Order requires a PO number.');
        }

        return [
            'transaction_id' => 'PO-' . $poNumber . '-' . time(),
            'po_number' => $poNumber, // Add PO number to payment result
        ];
    }
}