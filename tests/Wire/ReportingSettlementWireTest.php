<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementBatchesRequest;
use DateTime;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementTransactionsRequest;
use Payroc\Reporting\Settlement\Types\ListTransactionsSettlementRequestTransactionType;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAuthorizationsRequest;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementDisputesRequest;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAchDepositsRequest;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAchDepositFeesRequest;
use Payroc\Environments;

class ReportingSettlementWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testListBatches(): void {
        $testId = 'reporting.settlement.list_batches.0';
        $this->client->reporting->settlement->listBatches(
            new ListReportingSettlementBatchesRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2027-07-02'),
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_batches.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/batches",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2027-07-02', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    public function testRetrieveBatch(): void {
        $testId = 'reporting.settlement.retrieve_batch.0';
        $this->client->reporting->settlement->retrieveBatch(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.retrieve_batch.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/batches/1",
            null,
            1
        );
    }

    /**
     */
    public function testListTransactions(): void {
        $testId = 'reporting.settlement.list_transactions.0';
        $this->client->reporting->settlement->listTransactions(
            new ListReportingSettlementTransactionsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2024-07-02'),
                'batchId' => 1,
                'merchantId' => '4525644354',
                'transactionType' => ListTransactionsSettlementRequestTransactionType::Capture->value,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_transactions.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/transactions",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2024-07-02', 'batchId' => '1', 'merchantId' => '4525644354', 'transactionType' => 'Capture'],
            1
        );
    }

    /**
     */
    public function testRetrieveTransaction(): void {
        $testId = 'reporting.settlement.retrieve_transaction.0';
        $this->client->reporting->settlement->retrieveTransaction(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.retrieve_transaction.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/transactions/1",
            null,
            1
        );
    }

    /**
     */
    public function testListAuthorizations(): void {
        $testId = 'reporting.settlement.list_authorizations.0';
        $this->client->reporting->settlement->listAuthorizations(
            new ListReportingSettlementAuthorizationsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2024-07-02'),
                'batchId' => 1,
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_authorizations.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/authorizations",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2024-07-02', 'batchId' => '1', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    public function testRetrieveAuthorization(): void {
        $testId = 'reporting.settlement.retrieve_authorization.0';
        $this->client->reporting->settlement->retrieveAuthorization(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.retrieve_authorization.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/authorizations/1",
            null,
            1
        );
    }

    /**
     */
    public function testListDisputes(): void {
        $testId = 'reporting.settlement.list_disputes.0';
        $this->client->reporting->settlement->listDisputes(
            new ListReportingSettlementDisputesRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2024-07-02'),
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_disputes.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/disputes",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2024-07-02', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    public function testListDisputesStatuses(): void {
        $testId = 'reporting.settlement.list_disputes_statuses.0';
        $this->client->reporting->settlement->listDisputesStatuses(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_disputes_statuses.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/disputes/1/statuses",
            null,
            1
        );
    }

    /**
     */
    public function testListAchDeposits(): void {
        $testId = 'reporting.settlement.list_ach_deposits.0';
        $this->client->reporting->settlement->listAchDeposits(
            new ListReportingSettlementAchDepositsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2024-07-02'),
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_ach_deposits.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/ach-deposits",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2024-07-02', 'merchantId' => '4525644354'],
            1
        );
    }

    /**
     */
    public function testRetrieveAchDeposit(): void {
        $testId = 'reporting.settlement.retrieve_ach_deposit.0';
        $this->client->reporting->settlement->retrieveAchDeposit(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.retrieve_ach_deposit.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/ach-deposits/1",
            null,
            1
        );
    }

    /**
     */
    public function testListAchDepositFees(): void {
        $testId = 'reporting.settlement.list_ach_deposit_fees.0';
        $this->client->reporting->settlement->listAchDepositFees(
            new ListReportingSettlementAchDepositFeesRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'date' => new DateTime('2024-07-02'),
                'achDepositId' => 1,
                'merchantId' => '4525644354',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'reporting.settlement.list_ach_deposit_fees.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/ach-deposit-fees",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'date' => '2024-07-02', 'achDepositId' => '1', 'merchantId' => '4525644354'],
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
