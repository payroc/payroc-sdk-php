<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\CardPayments\Payments\Requests\ListPaymentsRequest;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestTender;
use DateTime;
use Payroc\CardPayments\Payments\Types\ListPaymentsRequestSettlementState;
use Payroc\CardPayments\Payments\Requests\PaymentRequest;
use Payroc\CardPayments\Payments\Types\PaymentRequestChannel;
use Payroc\Types\PaymentOrderRequest;
use Payroc\Types\Currency;
use Payroc\Types\Customer;
use Payroc\Types\Address;
use Payroc\Types\Shipping;
use Payroc\CardPayments\Payments\Types\PaymentRequestPaymentMethod;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\Types\CustomField;
use Payroc\CardPayments\Payments\Requests\PaymentAdjustment;
use Payroc\CardPayments\Payments\Types\PaymentAdjustmentAdjustmentsItem;
use Payroc\Types\CustomerAdjustment;
use Payroc\Types\OrderAdjustment;
use Payroc\CardPayments\Payments\Requests\PaymentCapture;
use Payroc\Types\ItemizedBreakdownRequest;
use Payroc\Types\LineItemRequest;
use Payroc\Environments;

class CardPaymentsPaymentsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'card_payments.payments.list_.0';
        $this->client->cardPayments->payments->list(
            new ListPaymentsRequest([
                'processingTerminalId' => '1234001',
                'orderId' => 'OrderRef6543',
                'operator' => 'Jane',
                'cardholderName' => 'Sarah%20Hazel%20Hopper',
                'first6' => '453985',
                'last4' => '7062',
                'tender' => ListPaymentsRequestTender::Ebt->value,
                'dateFrom' => new DateTime('2024-07-01T15:30:00Z'),
                'dateTo' => new DateTime('2024-07-03T15:30:00Z'),
                'settlementState' => ListPaymentsRequestSettlementState::Settled->value,
                'settlementDate' => new DateTime('2024-07-02'),
                'paymentLinkId' => 'JZURRJBUPS',
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.payments.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/payments",
            ['processingTerminalId' => '1234001', 'orderId' => 'OrderRef6543', 'operator' => 'Jane', 'cardholderName' => 'Sarah%20Hazel%20Hopper', 'first6' => '453985', 'last4' => '7062', 'tender' => 'ebt', 'dateFrom' => '2024-07-01T15:30:00Z', 'dateTo' => '2024-07-03T15:30:00Z', 'settlementState' => 'settled', 'settlementDate' => '2024-07-02', 'paymentLinkId' => 'JZURRJBUPS', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'card_payments.payments.create.0';
        $this->client->cardPayments->payments->create(
            new PaymentRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'channel' => PaymentRequestChannel::Web->value,
                'processingTerminalId' => '1234001',
                'operator' => 'Jane',
                'order' => new PaymentOrderRequest([
                    'orderId' => 'OrderRef6543',
                    'description' => 'Large Pepperoni Pizza',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                ]),
                'customer' => new Customer([
                    'firstName' => 'Sarah',
                    'lastName' => 'Hopper',
                    'billingAddress' => new Address([
                        'address1' => '1 Example Ave.',
                        'address2' => 'Example Address Line 2',
                        'address3' => 'Example Address Line 3',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'shippingAddress' => new Shipping([
                        'recipientName' => 'Sarah Hopper',
                        'address' => new Address([
                            'address1' => '1 Example Ave.',
                            'address2' => 'Example Address Line 2',
                            'address3' => 'Example Address Line 3',
                            'city' => 'Chicago',
                            'state' => 'Illinois',
                            'country' => 'US',
                            'postalCode' => '60056',
                        ]),
                    ]),
                ]),
                'paymentMethod' => PaymentRequestPaymentMethod::card(new CardPayload([
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
                    'X-Test-Id' => 'card_payments.payments.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payments",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'card_payments.payments.retrieve.0';
        $this->client->cardPayments->payments->retrieve(
            'M2MJOG6O2Y',
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.payments.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/payments/M2MJOG6O2Y",
            null,
            1
        );
    }

    /**
     */
    public function testAdjust(): void {
        $testId = 'card_payments.payments.adjust.0';
        $this->client->cardPayments->payments->adjust(
            'M2MJOG6O2Y',
            new PaymentAdjustment([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'adjustments' => [
                    PaymentAdjustmentAdjustmentsItem::customer(new CustomerAdjustment([])),
                    PaymentAdjustmentAdjustmentsItem::order(new OrderAdjustment([
                        'amount' => 4999,
                    ])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.payments.adjust.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payments/M2MJOG6O2Y/adjust",
            null,
            1
        );
    }

    /**
     */
    public function testCapture(): void {
        $testId = 'card_payments.payments.capture.0';
        $this->client->cardPayments->payments->capture(
            'M2MJOG6O2Y',
            new PaymentCapture([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
                'operator' => 'Jane',
                'amount' => 4999,
                'breakdown' => new ItemizedBreakdownRequest([
                    'subtotal' => 4999,
                    'dutyAmount' => 499,
                    'freightAmount' => 500,
                    'items' => [
                        new LineItemRequest([
                            'unitPrice' => 4000,
                            'quantity' => 1,
                        ]),
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'card_payments.payments.capture.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payments/M2MJOG6O2Y/capture",
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
