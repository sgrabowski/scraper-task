<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\ProductOptionSet;

interface ProductOptionSorter
{
    public function sort(ProductOptionSet $productOptionSet): ProductOptionSet;
}