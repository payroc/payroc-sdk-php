<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\RepeatPayments\PaymentPlans\Requests\ListPaymentPlansRequest;
use Payroc\RepeatPayments\PaymentPlans\Requests\CreatePaymentPlansRequest;
use Payroc\Types\PaymentPlan;
use Payroc\Types\Currency;
use Payroc\Types\PaymentPlanBaseType;
use Payroc\Types\PaymentPlanBaseFrequency;
use Payroc\Types\PaymentPlanBaseOnUpdate;
use Payroc\Types\PaymentPlanBaseOnDelete;
use Payroc\Types\PaymentPlanSetupOrder;
use Payroc\Types\PaymentPlanOrderBreakdown;
use Payroc\Types\RetrievedTax;
use Payroc\Types\PaymentPlanRecurringOrder;
use Payroc\RepeatPayments\PaymentPlans\Requests\PartiallyUpdatePaymentPlansRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\Environments;

class RepeatPaymentsPaymentPlansWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'repeat_payments.payment_plans.list_.0';
        $this->client->repeatPayments->paymentPlans->list(
            '1234001',
            new ListPaymentPlansRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.payment_plans.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/payment-plans",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'repeat_payments.payment_plans.create.0';
        $this->client->repeatPayments->paymentPlans->create(
            '1234001',
            new CreatePaymentPlansRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new PaymentPlan([
                    'paymentPlanId' => 'PlanRef8765',
                    'name' => 'Premium Club',
                    'description' => 'Monthly Premium Club subscription',
                    'currency' => Currency::Usd->value,
                    'length' => 12,
                    'type' => PaymentPlanBaseType::Automatic->value,
                    'frequency' => PaymentPlanBaseFrequency::Monthly->value,
                    'onUpdate' => PaymentPlanBaseOnUpdate::Continue_->value,
                    'onDelete' => PaymentPlanBaseOnDelete::Complete->value,
                    'customFieldNames' => [
                        'yourCustomField',
                    ],
                    'setupOrder' => new PaymentPlanSetupOrder([
                        'amount' => 4999,
                        'description' => 'Initial setup fee for Premium Club subscription',
                        'breakdown' => new PaymentPlanOrderBreakdown([
                            'subtotal' => 4347,
                            'taxes' => [
                                new RetrievedTax([
                                    'name' => 'Sales Tax',
                                    'rate' => 5,
                                ]),
                            ],
                        ]),
                    ]),
                    'recurringOrder' => new PaymentPlanRecurringOrder([
                        'amount' => 4999,
                        'description' => 'Monthly Premium Club subscription',
                        'breakdown' => new PaymentPlanOrderBreakdown([
                            'subtotal' => 4347,
                            'taxes' => [
                                new RetrievedTax([
                                    'name' => 'Sales Tax',
                                    'rate' => 5,
                                ]),
                            ],
                        ]),
                    ]),
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.payment_plans.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/payment-plans",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'repeat_payments.payment_plans.retrieve.0';
        $this->client->repeatPayments->paymentPlans->retrieve(
            '1234001',
            'PlanRef8765',
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.payment_plans.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/payment-plans/PlanRef8765",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'repeat_payments.payment_plans.delete.0';
        $this->client->repeatPayments->paymentPlans->delete(
            '1234001',
            'PlanRef8765',
            [
                'headers' => [
                    'X-Test-Id' => 'repeat_payments.payment_plans.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/processing-terminals/1234001/payment-plans/PlanRef8765",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'repeat_payments.payment_plans.partially_update.0';
        $this->client->repeatPayments->paymentPlans->partiallyUpdate(
            '1234001',
            'PlanRef8765',
            new PartiallyUpdatePaymentPlansRequest([
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
                    'X-Test-Id' => 'repeat_payments.payment_plans.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/processing-terminals/1234001/payment-plans/PlanRef8765",
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
