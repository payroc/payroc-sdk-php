<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Funding\FundingAccounts\Requests\ListFundingAccountsRequest;
use Payroc\Funding\FundingAccounts\Requests\UpdateFundingAccountsRequest;
use Payroc\Types\FundingAccount;
use Payroc\Types\FundingAccountType;
use Payroc\Types\FundingAccountUse;
use Payroc\Types\PaymentMethodsItem;
use Payroc\Types\PaymentMethodAch;
use Payroc\Environments;

class FundingFundingAccountsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'funding.funding_accounts.list_.0';
        $this->client->funding->fundingAccounts->list(
            new ListFundingAccountsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_accounts.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-accounts",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'funding.funding_accounts.retrieve.0';
        $this->client->funding->fundingAccounts->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_accounts.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-accounts/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'funding.funding_accounts.update.0';
        $this->client->funding->fundingAccounts->update(
            1,
            new UpdateFundingAccountsRequest([
                'body' => new FundingAccount([
                    'type' => FundingAccountType::Checking->value,
                    'use' => FundingAccountUse::Credit->value,
                    'nameOnAccount' => 'Jane Doe',
                    'paymentMethods' => [
                        PaymentMethodsItem::ach(new PaymentMethodAch([])),
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_accounts.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/funding-accounts/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'funding.funding_accounts.delete.0';
        $this->client->funding->fundingAccounts->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_accounts.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/funding-accounts/1",
            null,
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
