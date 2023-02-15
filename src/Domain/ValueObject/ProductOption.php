<?php

namespace App\Domain\ValueObject;

class ProductOption
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly MoneyAmount $price,
        private readonly MoneyAmount $discount,
        private readonly PaymentPeriod $paymentPeriod
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): MoneyAmount
    {
        return $this->price;
    }

    public function getDiscount(): MoneyAmount
    {
        return $this->discount;
    }

    public function getPaymentPeriod(): PaymentPeriod
    {
        return $this->paymentPeriod;
    }
}