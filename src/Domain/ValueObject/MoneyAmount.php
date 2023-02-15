<?php

namespace App\Domain\ValueObject;

class MoneyAmount
{
    //what fraction of the full unit is the subunit
    private const SUBUNIT_FRACTION = 1/100;

    private function __construct(private readonly int $amountInSubunit)
    {
    }

    public static function fromSubunitAmount(int $amountInSubunit): self
    {
        return new self($amountInSubunit);
    }

    public function toString(): string
    {
        $amountInMainUnit = $this->amountInSubunit * self::SUBUNIT_FRACTION;

        return number_format($amountInMainUnit, 2);
    }

    public function amountInSubunit(): int
    {
        return $this->amountInSubunit;
    }
}