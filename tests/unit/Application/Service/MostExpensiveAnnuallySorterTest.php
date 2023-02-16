<?php

namespace App\Tests\unit\Application\Service;

use App\Application\Service\MostExpensiveAnnuallySorter;
use App\Domain\ValueObject\MoneyAmount;
use App\Domain\ValueObject\PaymentPeriod;
use App\Domain\ValueObject\ProductOption;
use App\Domain\ValueObject\ProductOptionSet;
use PHPUnit\Framework\TestCase;

class MostExpensiveAnnuallySorterTest extends TestCase
{
    /**
     * @test
     */
    public function sorts_by_most_expensive_first(): void
    {
        $cheapestAnnual = new ProductOption(
            'cheapest',
            'cheapest',
            MoneyAmount::fromSubunitAmount(1000),
            MoneyAmount::fromSubunitAmount(0),
            PaymentPeriod::Annual
        );

        $middleAnnual = new ProductOption(
            'middle',
            'middle',
            MoneyAmount::fromSubunitAmount(1200),
            MoneyAmount::fromSubunitAmount(0),
            PaymentPeriod::Annual
        );

        $mostExpensiveMonthly = new ProductOption(
            'most expensive',
            'most expensive',
            MoneyAmount::fromSubunitAmount(121),
            MoneyAmount::fromSubunitAmount(0),
            PaymentPeriod::Monthly
        );

        $set = new ProductOptionSet([
            $mostExpensiveMonthly,
            $middleAnnual,
            $cheapestAnnual
        ]);

        $sorter = new MostExpensiveAnnuallySorter();

        $sorted = $sorter->sort($set);
        $result = $sorted->all();

        $this->assertSame($mostExpensiveMonthly, $result[0]);
        $this->assertSame($middleAnnual, $result[1]);
        $this->assertSame($cheapestAnnual, $result[2]);
    }
}