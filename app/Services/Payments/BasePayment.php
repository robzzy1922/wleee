<?php


namespace App\Services\Payments;

class BasePayment implements IPayment {
    protected float $amount;
    protected string $description;
    protected string $orderId;
    protected string $status;

    public function __construct(float $amount, string $description) {
        $this->amount = $amount;
        $this->description = $description;
        $this->status = 'pending';
        $this->orderId = 'ORDER-' . time();
    }

    public function process() {
        return [
            'status' => $this->status,
            'amount' => $this->amount,
            'order_id' => $this->orderId
        ];
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getStatus(): string {
        return $this->status;
    }
}