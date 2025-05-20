<?php

namespace App\Services\Payments;

abstract class PaymentDecorator implements IPayment {
    protected IPayment $payment;

    public function __construct(IPayment $payment) {
        $this->payment = $payment;
    }

    public function process() {
        return $this->payment->process();
    }

    public function getAmount(): float {
        return $this->payment->getAmount();
    }

    public function getDescription(): string {
        return $this->payment->getDescription();
    }

    public function getStatus(): string {
        return $this->payment->getStatus();
    }
}