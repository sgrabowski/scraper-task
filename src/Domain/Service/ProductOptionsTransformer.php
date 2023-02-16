<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\ProductOptionSet;

interface ProductOptionsTransformer
{
    public function transform(ProductOptionSet $productOptionSet): string;
}