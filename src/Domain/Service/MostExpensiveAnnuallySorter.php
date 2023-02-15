<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\PaymentPeriod;
use App\Domain\ValueObject\ProductOption;
use App\Domain\ValueObject\ProductOptionSet;

final class MostExpensiveAnnuallySorter implements ProductOptionSorter
{
    public function sort(ProductOptionSet $productOptionSet): ProductOptionSet
    {
        $productOptions = $productOptionSet->all();

        usort($productOptions, function (ProductOption $productOptionA, ProductOption $productOptionB) {
            //$productOptionB goes before $productOptionA if it has a higher annual price
            return $this->calculateAnnualPrice($productOptionB) <=> $this->calculateAnnualPrice($productOptionA);
        });

        return new ProductOptionSet($productOptions);
    }

    private function calculateAnnualPrice(ProductOption $productOption): int
    {
        if ($productOption->getPaymentPeriod() === PaymentPeriod::Annual) {
            return $productOption->getPrice()->amountInSubunit();
        }

        return $productOption->getPrice()->amountInSubunit() * 12;
    }
}