<?php

namespace App\Infrastructure;

use App\Domain\Service\ProductOptionsTransformer;
use App\Domain\ValueObject\ProductOptionSet;

final class JsonTransformer implements ProductOptionsTransformer
{
    public function transform(ProductOptionSet $productOptionSet): string
    {
        $transformedSet = [];

        foreach ($productOptionSet->all() as $productOption) {
            $transformedSet[] = [
                'option title' => $productOption->title(),
                'description' => $productOption->description(),
                'price' => $productOption->price()->toString(),
                'discount' => $productOption->discount()->toString()
            ];
        }

        return json_encode($transformedSet, JSON_PRETTY_PRINT);
    }
}