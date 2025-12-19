<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\BankTransferPayments\Refunds\Requests\ReversePaymentRefundsRequest;
use Payroc\BankTransferPayments\Refunds\Requests\BankTransferReferencedRefund;
use Payroc\BankTransferPayments\Refunds\Requests\ListRefundsRequest;
use DateTime;
use Payroc\BankTransferPayments\Refunds\Types\ListRefundsRequestSettlementState;
use Payroc\BankTransferPayments\Refunds\Requests\BankTransferUnreferencedRefund;
use Payroc\Types\BankTransferRefundOrder;
use Payroc\Types\Currency;
use Payroc\Types\BankTransferCustomer;
use Payroc\Types\BankTransferCustomerNotificationLanguage;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\BankTransferPayments\Refunds\Types\BankTransferUnreferencedRefundRefundMethod;
use Payroc\Types\AchPayload;
use Payroc\Types\CustomField;
use Payroc\BankTransferPayments\Refunds\Requests\ReverseRefundRefundsRequest;
use Payroc\Environments;

class BankTransferPaymentsRefundsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testReversePayment(): void {
        $testId = 'bank_transfer_payments.refunds.reverse_payment.0';
        $this->client->bankTransferPayments->refunds->reversePayment(
            'M2MJOG6O2Y',
            new ReversePaymentRefundsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.reverse_payment.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-payments/M2MJOG6O2Y/reverse",
            null,
            1
        );
    }

    /**
     */
    public function testRefund(): void {
        $testId = 'bank_transfer_payments.refunds.refund.0';
        $this->client->bankTransferPayments->refunds->refund(
            'M2MJOG6O2Y',
            new BankTransferReferencedRefund([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'amount' => 4999,
                'description' => 'amount to refund',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-payments/M2MJOG6O2Y/refund",
            null,
            1
        );
    }

    /**
     */
    public function testList_(): void {
        $testId = 'bank_transfer_payments.refunds.list_.0';
        $this->client->bankTransferPayments->refunds->list(
            new ListRefundsRequest([
                'processingTerminalId' => '1234001',
                'orderId' => 'OrderRef6543',
                'nameOnAccount' => 'Sarah%20Hazel%20Hopper',
                'last4' => '7062',
                'dateFrom' => new DateTime('2024-07-01T00:00:00Z'),
                'dateTo' => new DateTime('2024-07-31T23:59:59Z'),
                'settlementState' => ListRefundsRequestSettlementState::Settled->value,
                'settlementDate' => new DateTime('2024-07-15'),
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/bank-transfer-refunds",
            ['processingTerminalId' => '1234001', 'orderId' => 'OrderRef6543', 'nameOnAccount' => 'Sarah%20Hazel%20Hopper', 'last4' => '7062', 'dateFrom' => '2024-07-01T00:00:00Z', 'dateTo' => '2024-07-31T23:59:59Z', 'settlementState' => 'settled', 'settlementDate' => '2024-07-15', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'bank_transfer_payments.refunds.create.0';
        $this->client->bankTransferPayments->refunds->create(
            new BankTransferUnreferencedRefund([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
                'order' => new BankTransferRefundOrder([
                    'orderId' => 'OrderRef6543',
                    'description' => 'Refund for order OrderRef6543',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                ]),
                'customer' => new BankTransferCustomer([
                    'notificationLanguage' => BankTransferCustomerNotificationLanguage::En->value,
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                ]),
                'refundMethod' => BankTransferUnreferencedRefundRefundMethod::ach(new AchPayload([
                    'nameOnAccount' => 'Shara Hazel Hopper',
                    'accountNumber' => '1234567890',
                    'routingNumber' => '123456789',
                ])),
                'customFields' => [
                    new CustomField([
                        'name' => 'yourCustomField',
                        'value' => 'abc123',
                    ]),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-refunds",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'bank_transfer_payments.refunds.retrieve.0';
        $this->client->bankTransferPayments->refunds->retrieve(
            'CD3HN88U9F',
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/bank-transfer-refunds/CD3HN88U9F",
            null,
            1
        );
    }

    /**
     */
    public function testReverseRefund(): void {
        $testId = 'bank_transfer_payments.refunds.reverse_refund.0';
        $this->client->bankTransferPayments->refunds->reverseRefund(
            'CD3HN88U9F',
            new ReverseRefundRefundsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.refunds.reverse_refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-refunds/CD3HN88U9F/reverse",
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
