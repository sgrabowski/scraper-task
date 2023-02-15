<?php

namespace App\Tests\Domain\ValueObject;

use App\Domain\ValueObject\MoneyAmount;
use PHPUnit\Framework\TestCase;

class MoneyAmountTest extends TestCase
{
    /**
     * @test
     * @dataProvider subunitAmountToExpectedStringSet
     */
    public function can_be_built_from_subunit_and_formatted_to_string(int $subunitAmount, string $expectedResult): void
    {
        $moneyAmount = MoneyAmount::fromSubunitAmount($subunitAmount);
        $this->assertSame($subunitAmount, $moneyAmount->amountInSubunit());
        $this->assertSame($expectedResult, $moneyAmount->toString());
    }

    public function subunitAmountToExpectedStringSet(): array
    {
        return [
            [1, '0.01'],
            [12, '0.12'],
            [123, '1.23'],
            [9999, '99.99'],
            [10000, '100.00']
        ];
    }
}