<?php

namespace App\Tests\unit\Infrastructure;

use App\Domain\ValueObject\MoneyAmount;
use App\Domain\ValueObject\PaymentPeriod;
use App\Domain\ValueObject\ProductOption;
use App\Domain\ValueObject\ProductOptionSet;
use App\Infrastructure\JsonTransformer;
use PHPUnit\Framework\TestCase;

class JsonTransformerTest extends TestCase
{
    /**
     * @test
     */
    public function transforms_option_set_to_json(): void
    {
        $productOptionA = new ProductOption(
            'A',
            'A',
            MoneyAmount::fromSubunitAmount(1000),
            MoneyAmount::fromSubunitAmount(10),
            PaymentPeriod::Annual
        );

        $productOptionB = new ProductOption(
            'B',
            'B',
            MoneyAmount::fromSubunitAmount(1000),
            MoneyAmount::fromSubunitAmount(10),
            PaymentPeriod::Monthly
        );

        $set = new ProductOptionSet([
            $productOptionA,
            $productOptionB
        ]);

        $transformer = new JsonTransformer();
        $result = $transformer->transform($set);

        $expectedResult = <<<JSN
[
    {
        "option title": "A",
        "description": "A",
        "price": "10.00",
        "discount": "0.10"
    },
    {
        "option title": "B",
        "description": "B",
        "price": "10.00",
        "discount": "0.10"
    }
]
JSN;

        $this->assertSame($expectedResult, $result);
    }
}