<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\CardPayments\Refunds\Requests\PaymentReversal;
use Payroc\CardPayments\Refunds\Requests\ReferencedRefund;
use Payroc\CardPayments\Refunds\Requests\ListRefundsRequest;
use Payroc\CardPayments\Refunds\Types\ListRefundsRequestTender;
use DateTime;
use Payroc\CardPayments\Refunds\Types\ListRefundsRequestSettlementState;
use Payroc\CardPayments\Refunds\Requests\UnreferencedRefund;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundChannel;
use Payroc\Types\RefundOrder;
use Payroc\Types\Currency;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundRefundMethod;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\Types\CustomField;
use Payroc\CardPayments\Refunds\Requests\RefundAdjustment;
use Payroc\CardPayments\Refunds\Types\RefundAdjustmentAdjustmentsItem;
use Payroc\Types\CustomerAdjustment;
use Payroc\CardPayments\Refunds\Requests\ReverseRefundRefundsRequest;
use Payroc\Environments;

class CardPaymentsRefundsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testReverse(): void {
        $testId = 'card_payments.refunds.reverse.0';
        $this->client->cardPayments->refunds->reverse(
            'M2MJOG6O2Y',
            new PaymentReversal([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'amount' => 4999,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.reverse.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payments/M2MJOG6O2Y/reverse",
            null,
            1
        );
    }

    /**
     */
    public function testCreateReferencedRefund(): void {
        $testId = 'card_payments.refunds.create_referenced_refund.0';
        $this->client->cardPayments->refunds->createReferencedRefund(
            'M2MJOG6O2Y',
            new ReferencedRefund([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'amount' => 4999,
                'description' => 'Refund for order OrderRef6543',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.create_referenced_refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payments/M2MJOG6O2Y/refund",
            null,
            1
        );
    }

    /**
     */
    public function testList_(): void {
        $testId = 'card_payments.refunds.list_.0';
        $this->client->cardPayments->refunds->list(
            new ListRefundsRequest([
                'processingTerminalId' => '1234001',
                'orderId' => 'OrderRef6543',
                'operator' => 'Jane',
                'cardholderName' => 'Sarah%20Hazel%20Hopper',
                'first6' => '453985',
                'last4' => '7062',
                'tender' => ListRefundsRequestTender::Ebt->value,
                'dateFrom' => new DateTime('2024-07-01T15:30:00Z'),
                'dateTo' => new DateTime('2024-07-03T15:30:00Z'),
                'settlementState' => ListRefundsRequestSettlementState::Settled->value,
                'settlementDate' => new DateTime('2024-07-02'),
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/refunds",
            ['processingTerminalId' => '1234001', 'orderId' => 'OrderRef6543', 'operator' => 'Jane', 'cardholderName' => 'Sarah%20Hazel%20Hopper', 'first6' => '453985', 'last4' => '7062', 'tender' => 'ebt', 'dateFrom' => '2024-07-01T15:30:00Z', 'dateTo' => '2024-07-03T15:30:00Z', 'settlementState' => 'settled', 'settlementDate' => '2024-07-02', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreateUnreferencedRefund(): void {
        $testId = 'card_payments.refunds.create_unreferenced_refund.0';
        $this->client->cardPayments->refunds->createUnreferencedRefund(
            new UnreferencedRefund([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'channel' => UnreferencedRefundChannel::Pos->value,
                'processingTerminalId' => '1234001',
                'order' => new RefundOrder([
                    'orderId' => 'OrderRef6543',
                    'description' => 'Refund for order OrderRef6543',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                ]),
                'refundMethod' => UnreferencedRefundRefundMethod::card(new CardPayload([
                    'cardDetails' => CardPayloadCardDetails::raw(new RawCardDetails([
                        'device' => new Device([
                            'model' => DeviceModel::BbposChp->value,
                            'serialNumber' => '1850010868',
                        ]),
                        'rawData' => 'A1B2C3D4E5F67890ABCD1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
                    ])),
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
                    'X-Test-Id' => 'card_payments.refunds.create_unreferenced_refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/refunds",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'card_payments.refunds.retrieve.0';
        $this->client->cardPayments->refunds->retrieve(
            'CD3HN88U9F',
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/refunds/CD3HN88U9F",
            null,
            1
        );
    }

    /**
     */
    public function testAdjust(): void {
        $testId = 'card_payments.refunds.adjust.0';
        $this->client->cardPayments->refunds->adjust(
            'CD3HN88U9F',
            new RefundAdjustment([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'operator' => 'Jane',
                'adjustments' => [
                    RefundAdjustmentAdjustmentsItem::customer(new CustomerAdjustment([])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.adjust.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/refunds/CD3HN88U9F/adjust",
            null,
            1
        );
    }

    /**
     */
    public function testReverseRefund(): void {
        $testId = 'card_payments.refunds.reverse_refund.0';
        $this->client->cardPayments->refunds->reverseRefund(
            'CD3HN88U9F',
            new ReverseRefundRefundsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.refunds.reverse_refund.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/refunds/CD3HN88U9F/reverse",
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
