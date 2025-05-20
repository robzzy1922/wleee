<?php

namespace App\Services\Payments;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;

class MidtransPaymentDecorator extends PaymentDecorator {
    protected string $snapToken;

    public function __construct(IPayment $payment) {
        parent::__construct($payment);
        $this->initializeMidtrans();
    }

    private function initializeMidtrans() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function process() {
        $baseResult = parent::process();

        $params = [
            'transaction_details' => [
                'order_id' => $baseResult['order_id'],
                'gross_amount' => $this->getAmount(),
            ],
                'first_name' => Auth::user()->name,
        ];

        try {
            $this->snapToken = Snap::getSnapToken($params);
            return array_merge($baseResult, ['snap_token' => $this->snapToken]);
        } catch (\Exception $e) {
            logger()->error('Midtrans Error: ' . $e->getMessage());
            throw $e;
        }
    }
}