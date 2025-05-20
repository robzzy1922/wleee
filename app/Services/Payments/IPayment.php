<?php

namespace App\Services\Payments;

interface IPayment {
    public function process();
    public function getAmount(): float;
    public function getDescription(): string;
    public function getStatus(): string;
}