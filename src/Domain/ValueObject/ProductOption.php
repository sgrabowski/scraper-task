<?php

namespace App\Domain\ValueObject;

final class ProductOption
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly MoneyAmount $price,
        private readonly MoneyAmount $discount,
        private readonly PaymentPeriod $paymentPeriod
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): MoneyAmount
    {
        return $this->price;
    }

    public function discount(): MoneyAmount
    {
        return $this->discount;
    }

    public function paymentPeriod(): PaymentPeriod
    {
        return $this->paymentPeriod;
    }
}