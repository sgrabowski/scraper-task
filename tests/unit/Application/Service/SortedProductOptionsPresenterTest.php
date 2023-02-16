<?php

namespace App\Tests\unit\Application\Service;

use App\Application\Service\SortedProductOptionsPresenter;
use App\Domain\Provider\ProductOptionsProvider;
use App\Domain\Service\ProductOptionSorter;
use App\Domain\Service\ProductOptionsTransformer;
use App\Domain\ValueObject\MoneyAmount;
use App\Domain\ValueObject\PaymentPeriod;
use App\Domain\ValueObject\ProductOption;
use App\Domain\ValueObject\ProductOptionSet;
use PHPUnit\Framework\TestCase;

class SortedProductOptionsPresenterTest extends TestCase
{
    /**
     * @test
     */
    public function presents_sorted_product_options(): void
    {
        $productOptionA = new ProductOption(
            'A',
            'A',
            MoneyAmount::fromSubunitAmount(1000),
            MoneyAmount::fromSubunitAmount(0),
            PaymentPeriod::Annual
        );

        $productOptionB = new ProductOption(
            'B',
            'B',
            MoneyAmount::fromSubunitAmount(1000),
            MoneyAmount::fromSubunitAmount(0),
            PaymentPeriod::Monthly
        );

        $set = new ProductOptionSet([
            $productOptionA,
            $productOptionB
        ]);

        $provider = $this->createMock(ProductOptionsProvider::class);
        $provider->expects($this->once())->method('provide')
            ->willReturn($set);

        $sorter = $this->createMock(ProductOptionSorter::class);
        $sorter->expects($this->once())->method('sort')
            ->with($set)->willReturn($set);

        $transformer = $this->createMock(ProductOptionsTransformer::class);
        $transformer->expects($this->once())->method('transform')
            ->with($set)->willReturn('transformed');

        $presenter = new SortedProductOptionsPresenter($provider, $sorter, $transformer);

        $this->assertSame('transformed', $presenter->present());
    }
}