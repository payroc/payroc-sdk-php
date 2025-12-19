<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\RepeatPayments\Subscriptions\Requests\ListSubscriptionsRequest;
use Payroc\RepeatPayments\Subscriptions\Types\ListSubscriptionsRequestFrequency;
use Payroc\RepeatPayments\Subscriptions\Types\ListSubscriptionsRequestStatus;
use DateTime;
use Payroc\RepeatPayments\Subscriptions\Requests\SubscriptionRequest;
use Payroc\RepeatPayments\Subscriptions\Types\SubscriptionRequestPaymentMethod;
use Payroc\Types\SecureTokenPayload;
use Payroc\Types\SubscriptionPaymentOrderRequest;
use Payroc\Types\SubscriptionRecurringOrderRequest;
use Payroc\Types\SubscriptionOrderBreakdownRequest;
use Payroc\Types\TaxRate;
use Payroc\Types\TaxRateType;
use Payroc\RepeatPayments\Subscriptions\Requests\PartiallyUpdateSubscriptionsRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\RepeatPayments\Subscriptions\Requests\SubscriptionPaymentRequest;
use Payroc\Types\SubscriptionPaymentOrder;
use Payroc\Environments;

class RepeatPaymentsSubscriptionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'repeat_payments.subscriptions.list_.0';
        $this->client->repeatPayments->subscriptions->list(
            '1234001',
            new ListSubscriptionsRequest([
                'customerName' => 'Sarah%20Hazel%20Hopper',
                'last4' => '7062',
                'paymentPlan' => 'Premium%20Club',
                'frequency' => ListSubscriptionsRequestFrequency::Weekly->value,
                'status' => ListSubscriptionsRequestStatus::Active->value,
                'endDate' => new DateTime('2025-07-01'),
                'nextDueDate' => new DateTime('2024-08-01'),
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/subscriptions",
            ['customerName' => 'Sarah%20Hazel%20Hopper', 'last4' => '7062', 'paymentPlan' => 'Premium%20Club', 'frequency' => 'weekly', 'status' => 'active', 'endDate' => '2025-07-01', 'nextDueDate' => '2024-08-01', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'repeat_payments.subscriptions.create.0';
        $this->client->repeatPayments->subscriptions->create(
            '1234001',
            new SubscriptionRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'subscriptionId' => 'SubRef7654',
                'paymentPlanId' => 'PlanRef8765',
                'paymentMethod' => SubscriptionRequestPaymentMethod::secureToken(new SecureTokenPayload([
                    'token' => '1234567890123456789',
                ])),
                'name' => 'Premium Club',
                'description' => 'Premium Club subscription',
                'setupOrder' => new SubscriptionPaymentOrderRequest([
                    'orderId' => 'OrderRef6543',
                    'amount' => 4999,
                    'description' => 'Initial setup fee for Premium Club subscription',
                ]),
                'recurringOrder' => new SubscriptionRecurringOrderRequest([
                    'amount' => 4999,
                    'description' => 'Monthly Premium Club subscription',
                    'breakdown' => new SubscriptionOrderBreakdownRequest([
                        'subtotal' => 4347,
                        'taxes' => [
                            new TaxRate([
                                'type' => TaxRateType::Rate->value,
                                'rate' => 5,
                                'name' => 'Sales Tax',
                            ]),
                        ],
                    ]),
                ]),
                'startDate' => new DateTime('2024-07-02'),
                'endDate' => new DateTime('2025-07-01'),
                'length' => 12,
                'pauseCollectionFor' => 0,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/subscriptions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'repeat_payments.subscriptions.retrieve.0';
        $this->client->repeatPayments->subscriptions->retrieve(
            '1234001',
            'SubRef7654',
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/subscriptions/SubRef7654",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'repeat_payments.subscriptions.partially_update.0';
        $this->client->repeatPayments->subscriptions->partiallyUpdate(
            '1234001',
            'SubRef7654',
            new PartiallyUpdateSubscriptionsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => [
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/processing-terminals/1234001/subscriptions/SubRef7654",
            null,
            1
        );
    }

    /**
     */
    public function testDeactivate(): void {
        $testId = 'repeat_payments.subscriptions.deactivate.0';
        $this->client->repeatPayments->subscriptions->deactivate(
            '1234001',
            'SubRef7654',
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.deactivate.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/subscriptions/SubRef7654/deactivate",
            null,
            1
        );
    }

    /**
     */
    public function testReactivate(): void {
        $testId = 'repeat_payments.subscriptions.reactivate.0';
        $this->client->repeatPayments->subscriptions->reactivate(
            '1234001',
            'SubRef7654',
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.reactivate.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/subscriptions/SubRef7654/reactivate",
            null,
            1
        );
    }

    /**
     */
    public function testPay(): void {
        $testId = 'repeat_payments.subscriptions.pay.0';
        $this->client->repeatPayments->subscriptions->pay(
            '1234001',
            'SubRef7654',
            new SubscriptionPaymentRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'operator' => 'Jane',
                'order' => new SubscriptionPaymentOrder([
                    'orderId' => 'OrderRef6543',
                    'amount' => 4999,
                    'description' => 'Monthly Premium Club subscription',
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.subscriptions.pay.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/subscriptions/SubRef7654/pay",
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
