<?php

namespace App\Domain\Provider;

use App\Domain\ValueObject\ProductOptionSet;

interface ProductOptionsProvider
{
    public function provide(): ProductOptionSet;
}