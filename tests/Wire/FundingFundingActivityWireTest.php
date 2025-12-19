<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Funding\FundingActivity\Requests\RetrieveBalanceFundingActivityRequest;
use Payroc\Funding\FundingActivity\Requests\ListFundingActivityRequest;
use DateTime;
use Payroc\Environments;

class FundingFundingActivityWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieveBalance(): void {
        $testId = 'funding.funding_activity.retrieve_balance.0';
        $this->client->funding->fundingActivity->retrieveBalance(
            new RetrieveBalanceFundingActivityRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_activity.retrieve_balance.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-balance",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    public function testList_(): void {
        $testId = 'funding.funding_activity.list_.0';
        $this->client->funding->fundingActivity->list(
            new ListFundingActivityRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'dateFrom' => new DateTime('2024-07-02'),
                'dateTo' => new DateTime('2024-07-03'),
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_activity.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-activity",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'dateFrom' => '2024-07-02', 'dateTo' => '2024-07-03', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    protected function setUp(): void {
        parent::setUp();
        $this->client = new PayrocClient(
            apiKey: 'test-apiKey',
            environment: Environments::custom('http://localhost:8080', 'http://localhost:8080'),
        );
    }
}
