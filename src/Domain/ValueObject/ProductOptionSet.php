<?php

namespace App\Domain\ValueObject;

final class ProductOptionSet
{
    private array $productOptions = [];

    /**
     * @param array<ProductOption> $productOptions
     */
    public function __construct(array $productOptions)
    {
        foreach ($productOptions as $productOption) {
            $this->add($productOption);
        }
    }

    private function add(ProductOption $productOption): void
    {
        $this->productOptions[] = $productOption;
    }

    /**
     * @return array<ProductOption>
     */
    public function all(): array
    {
        return $this->productOptions;
    }
}