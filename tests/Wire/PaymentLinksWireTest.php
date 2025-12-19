<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PaymentLinks\Requests\ListPaymentLinksRequest;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestLinkType;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestChargeType;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestStatus;
use DateTime;
use Payroc\PaymentLinks\Requests\CreatePaymentLinksRequest;
use Payroc\PaymentLinks\Types\CreatePaymentLinksRequestBody;
use Payroc\Types\MultiUsePaymentLink;
use Payroc\Types\MultiUsePaymentLinkOrder;
use Payroc\Types\MultiUsePaymentLinkOrderCharge;
use Payroc\Types\PromptPaymentLinkCharge;
use Payroc\Types\Currency;
use Payroc\Types\MultiUsePaymentLinkAuthType;
use Payroc\Types\MultiUsePaymentLinkPaymentMethodsItem;
use Payroc\PaymentLinks\Requests\PartiallyUpdatePaymentLinksRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\Environments;

class PaymentLinksWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'payment_links.list_.0';
        $this->client->paymentLinks->list(
            '1234001',
            new ListPaymentLinksRequest([
                'merchantReference' => 'LinkRef6543',
                'linkType' => ListPaymentLinksRequestLinkType::MultiUse->value,
                'chargeType' => ListPaymentLinksRequestChargeType::Preset->value,
                'status' => ListPaymentLinksRequestStatus::Active->value,
                'recipientName' => 'Sarah Hazel Hopper',
                'recipientEmail' => 'sarah.hopper@example.com',
                'createdOn' => new DateTime('2024-07-02'),
                'expiresOn' => new DateTime('2024-08-02'),
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/payment-links",
            ['merchantReference' => 'LinkRef6543', 'linkType' => 'multiUse', 'chargeType' => 'preset', 'status' => 'active', 'recipientName' => 'Sarah Hazel Hopper', 'recipientEmail' => 'sarah.hopper@example.com', 'createdOn' => '2024-07-02', 'expiresOn' => '2024-08-02', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'payment_links.create.0';
        $this->client->paymentLinks->create(
            '1234001',
            new CreatePaymentLinksRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => CreatePaymentLinksRequestBody::multiUse(new MultiUsePaymentLink([
                    'merchantReference' => 'LinkRef6543',
                    'order' => new MultiUsePaymentLinkOrder([
                        'charge' => MultiUsePaymentLinkOrderCharge::prompt(new PromptPaymentLinkCharge([
                            'currency' => Currency::Aed->value,
                        ])),
                    ]),
                    'authType' => MultiUsePaymentLinkAuthType::Sale->value,
                    'paymentMethods' => [
                        MultiUsePaymentLinkPaymentMethodsItem::Card->value,
                    ],
                ])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/payment-links",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'payment_links.retrieve.0';
        $this->client->paymentLinks->retrieve(
            'JZURRJBUPS',
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/payment-links/JZURRJBUPS",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'payment_links.partially_update.0';
        $this->client->paymentLinks->partiallyUpdate(
            'JZURRJBUPS',
            new PartiallyUpdatePaymentLinksRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => [
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/payment-links/JZURRJBUPS",
            null,
            1
        );
    }

    /**
     */
    public function testDeactivate(): void {
        $testId = 'payment_links.deactivate.0';
        $this->client->paymentLinks->deactivate(
            'JZURRJBUPS',
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.deactivate.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payment-links/JZURRJBUPS/deactivate",
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
