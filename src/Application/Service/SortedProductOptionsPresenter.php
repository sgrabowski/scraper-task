<?php

namespace App\Application\Service;

use App\Domain\Provider\ProductOptionsProvider;
use App\Domain\Service\ProductOptionSorter;
use App\Domain\Service\ProductOptionsTransformer;

final class SortedProductOptionsPresenter
{
    public function __construct(
        private readonly ProductOptionsProvider    $provider,
        private readonly ProductOptionSorter       $sorter,
        private readonly ProductOptionsTransformer $transformer
    ) {
    }

    public function present(): string
    {
        return $this->transformer->transform($this->sorter->sort($this->provider->provide()));
    }
}