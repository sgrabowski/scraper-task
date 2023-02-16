<?php

namespace App\Tests\functional\Infrastructure;

use App\Domain\ValueObject\PaymentPeriod;
use App\Infrastructure\GoutteProductOptionsScraper;
use Goutte\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class GoutteProductOptionsScraperTest extends TestCase
{
    private Client $client;

    protected function setUp(): void
    {
        $mockClient = new MockHttpClient([
            new MockResponse(file_get_contents(__DIR__.'/../../data/response'))
        ]);

        $this->client = new Client($mockClient);
    }

    /**
     * @test
     */
    public function scrapes_option_data(): void
    {
        $scraper = new GoutteProductOptionsScraper($this->client);

        $set = $scraper->provide();
        $options = $set->all();

        $this->assertCount(6, $options);

        $firstOption = $options[0];
        $lastOption = $options[5];

        $this->assertSame('Basic: 500MB Data - 12 Months', $firstOption->title());
        $this->assertSame('The basic starter subscription providing you with all you need to get your device up and running with inclusive Data and SMS services.', $firstOption->description());
        $this->assertSame(599, $firstOption->price()->amountInSubunit());
        $this->assertSame(0, $firstOption->discount()->amountInSubunit());
        $this->assertSame(PaymentPeriod::Monthly, $firstOption->paymentPeriod());

        $this->assertSame('Optimum: 24GB Data - 1 Year', $lastOption->title());
        $this->assertSame('The optimum subscription providing you with enough service time to support the above-average with data and SMS services to allow access to your device.', $lastOption->description());
        $this->assertSame(17400, $lastOption->price()->amountInSubunit());
        $this->assertSame(1790, $lastOption->discount()->amountInSubunit());
        $this->assertSame(PaymentPeriod::Annual, $lastOption->paymentPeriod());
    }
}