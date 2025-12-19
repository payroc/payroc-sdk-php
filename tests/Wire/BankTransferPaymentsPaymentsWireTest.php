<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\BankTransferPayments\Payments\Requests\ListPaymentsRequest;
use DateTime;
use Payroc\BankTransferPayments\Payments\Types\ListPaymentsRequestSettlementState;
use Payroc\BankTransferPayments\Payments\Requests\BankTransferPaymentRequest;
use Payroc\Types\BankTransferPaymentRequestOrder;
use Payroc\Types\Currency;
use Payroc\Types\BankTransferRequestBreakdown;
use Payroc\Types\Tip;
use Payroc\Types\TipType;
use Payroc\Types\TaxRate;
use Payroc\Types\TaxRateType;
use Payroc\Types\BankTransferCustomer;
use Payroc\Types\BankTransferCustomerNotificationLanguage;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Types\SchemasCredentialOnFile;
use Payroc\BankTransferPayments\Payments\Types\BankTransferPaymentRequestPaymentMethod;
use Payroc\Types\AchPayload;
use Payroc\Types\CustomField;
use Payroc\BankTransferPayments\Payments\Requests\Representment;
use Payroc\BankTransferPayments\Payments\Types\RepresentmentPaymentMethod;
use Payroc\Environments;

class BankTransferPaymentsPaymentsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'bank_transfer_payments.payments.list_.0';
        $this->client->bankTransferPayments->payments->list(
            new ListPaymentsRequest([
                'processingTerminalId' => '1234001',
                'orderId' => 'OrderRef6543',
                'nameOnAccount' => 'Sarah%20Hazel%20Hopper',
                'last4' => '7890',
                'dateFrom' => new DateTime('2024-07-01T00:00:00Z'),
                'dateTo' => new DateTime('2024-07-31T23:59:59Z'),
                'settlementState' => ListPaymentsRequestSettlementState::Settled->value,
                'settlementDate' => new DateTime('2024-07-15'),
                'paymentLinkId' => 'JZURRJBUPS',
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.payments.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/bank-transfer-payments",
            ['processingTerminalId' => '1234001', 'orderId' => 'OrderRef6543', 'nameOnAccount' => 'Sarah%20Hazel%20Hopper', 'last4' => '7890', 'dateFrom' => '2024-07-01T00:00:00Z', 'dateTo' => '2024-07-31T23:59:59Z', 'settlementState' => 'settled', 'settlementDate' => '2024-07-15', 'paymentLinkId' => 'JZURRJBUPS', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'bank_transfer_payments.payments.create.0';
        $this->client->bankTransferPayments->payments->create(
            new BankTransferPaymentRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
                'order' => new BankTransferPaymentRequestOrder([
                    'orderId' => 'OrderRef6543',
                    'description' => 'Large Pepperoni Pizza',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                    'breakdown' => new BankTransferRequestBreakdown([
                        'subtotal' => 4347,
                        'tip' => new Tip([
                            'type' => TipType::Percentage->value,
                            'percentage' => 10,
                        ]),
                        'taxes' => [
                            new TaxRate([
                                'type' => TaxRateType::Rate->value,
                                'rate' => 5,
                                'name' => 'Sales Tax',
                            ]),
                        ],
                    ]),
                ]),
                'customer' => new BankTransferCustomer([
                    'notificationLanguage' => BankTransferCustomerNotificationLanguage::En->value,
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                ]),
                'credentialOnFile' => new SchemasCredentialOnFile([
                    'tokenize' => true,
                ]),
                'paymentMethod' => BankTransferPaymentRequestPaymentMethod::ach(new AchPayload([
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
                    'X-Test-Id' => 'bank_transfer_payments.payments.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-payments",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'bank_transfer_payments.payments.retrieve.0';
        $this->client->bankTransferPayments->payments->retrieve(
            'M2MJOG6O2Y',
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.payments.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/bank-transfer-payments/M2MJOG6O2Y",
            null,
            1
        );
    }

    /**
     */
    public function testRepresent(): void {
        $testId = 'bank_transfer_payments.payments.represent.0';
        $this->client->bankTransferPayments->payments->represent(
            'M2MJOG6O2Y',
            new Representment([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'paymentMethod' => RepresentmentPaymentMethod::ach(new AchPayload([
                    'nameOnAccount' => 'Shara Hazel Hopper',
                    'accountNumber' => '1234567890',
                    'routingNumber' => '123456789',
                ])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'bank_transfer_payments.payments.represent.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-transfer-payments/M2MJOG6O2Y/represent",
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
