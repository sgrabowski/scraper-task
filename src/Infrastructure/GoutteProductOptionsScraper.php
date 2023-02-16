<?php

namespace App\Infrastructure;

use App\Domain\Provider\ProductOptionsProvider;
use App\Domain\ValueObject\MoneyAmount;
use App\Domain\ValueObject\PaymentPeriod;
use App\Domain\ValueObject\ProductOption;
use App\Domain\ValueObject\ProductOptionSet;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

final class GoutteProductOptionsScraper implements ProductOptionsProvider
{
    private const SOURCE_URL = 'https://wltest.dns-systems.net/';
    private const PRICE_REGEXP = '/\d+\.\d{2}/';

    public function __construct(private readonly Client $client)
    {
    }

    public function provide(): ProductOptionSet
    {
        $crawler = $this->client->request('GET', self::SOURCE_URL);

        $scrapedOptions = [];

        $crawler->filter('div.package')->each(function (Crawler $node) use (&$scrapedOptions) {
            $title = $node->filter('div.header')->first()->text();

            $listItems = $node->filter('div.package-features li');

            $description = $listItems->eq(0)->text();

            $priceAndDiscountFullText = $listItems->eq(2)->text();
            $price = $this->extractPrice($priceAndDiscountFullText);
            $discount = $this->extractDiscount($priceAndDiscountFullText);

            $period = str_contains($title, '12 Months') ? PaymentPeriod::Monthly : PaymentPeriod::Annual;

            $scrapedOptions[] = new ProductOption(
                $title,
                $description,
                MoneyAmount::fromSubunitAmount($price),
                MoneyAmount::fromSubunitAmount($discount),
                $period
            );
        });

        return new ProductOptionSet($scrapedOptions);
    }

    private function extractPrice(string $priceAndDiscountFullText): int
    {
        $matches = [];
        preg_match(self::PRICE_REGEXP, $priceAndDiscountFullText, $matches);

        if (empty($matches)) {
            throw new \RuntimeException('Failed to scrape price from text: %s', $priceAndDiscountFullText);
        }

        return intval(str_replace('.', '', $matches[0]));
    }

    private function extractDiscount(string $priceAndDiscountFullText): int
    {
        $matches = [];
        preg_match_all(self::PRICE_REGEXP, $priceAndDiscountFullText, $matches);

        if (count($matches[0]) < 2) {
            return 0;
        }

        return intval(str_replace('.', '', $matches[0][1]));
    }
}