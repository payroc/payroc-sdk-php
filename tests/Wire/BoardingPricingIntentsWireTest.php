<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Boarding\PricingIntents\Requests\ListPricingIntentsRequest;
use Payroc\Boarding\PricingIntents\Requests\CreatePricingIntentsRequest;
use Payroc\Types\PricingIntent50;
use Payroc\Types\PricingAgreementUs50Country;
use Payroc\Types\PricingAgreementUs50Version;
use Payroc\Types\BaseUs;
use Payroc\Types\BaseUsAnnualFee;
use Payroc\Types\BaseUsAnnualFeeBillInMonth;
use Payroc\Types\BaseUsPlatinumSecurity;
use Payroc\Types\BaseUsMonthly;
use Payroc\Types\PricingAgreementUs50Processor;
use Payroc\Types\PricingAgreementUs50ProcessorCard;
use Payroc\Types\InterchangePlus;
use Payroc\Types\InterchangePlusFees;
use Payroc\Types\ProcessorFee;
use Payroc\Types\ServiceUs50;
use Payroc\Types\HardwareAdvantagePlan;
use Payroc\Boarding\PricingIntents\Requests\UpdatePricingIntentsRequest;
use Payroc\Types\Ach;
use Payroc\Types\AchFees;
use Payroc\Types\GatewayUs50;
use Payroc\Types\GatewayUs50Fees;
use Payroc\Boarding\PricingIntents\Requests\PartiallyUpdatePricingIntentsRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\Environments;

class BoardingPricingIntentsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'boarding.pricing_intents.list_.0';
        $this->client->boarding->pricingIntents->list(
            new ListPricingIntentsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.pricing_intents.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/pricing-intents",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'boarding.pricing_intents.create.0';
        $this->client->boarding->pricingIntents->create(
            new CreatePricingIntentsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new PricingIntent50([
                    'country' => PricingAgreementUs50Country::Us->value,
                    'version' => PricingAgreementUs50Version::Five0->value,
                    'base' => new BaseUs([
                        'addressVerification' => 5,
                        'annualFee' => new BaseUsAnnualFee([
                            'billInMonth' => BaseUsAnnualFeeBillInMonth::June->value,
                            'amount' => 9900,
                        ]),
                        'regulatoryAssistanceProgram' => 15,
                        'pciNonCompliance' => 4995,
                        'merchantAdvantage' => 10,
                        'platinumSecurity' => BaseUsPlatinumSecurity::monthly(new BaseUsMonthly([])),
                        'maintenance' => 500,
                        'minimum' => 100,
                        'voiceAuthorization' => 95,
                        'chargeback' => 2500,
                        'retrieval' => 1500,
                        'batch' => 1500,
                        'earlyTermination' => 57500,
                    ]),
                    'processor' => new PricingAgreementUs50Processor([
                        'card' => PricingAgreementUs50ProcessorCard::interchangePlus(new InterchangePlus([
                            'fees' => new InterchangePlusFees([
                                'mastercardVisaDiscover' => new ProcessorFee([]),
                            ]),
                        ])),
                    ]),
                    'services' => [
                        ServiceUs50::hardwareAdvantagePlan(new HardwareAdvantagePlan([
                            'enabled' => true,
                        ])),
                    ],
                    'key' => 'Your-Unique-Identifier',
                    'metadata' => [
                        'yourCustomField' => 'abc123',
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.pricing_intents.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/pricing-intents",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.pricing_intents.retrieve.0';
        $this->client->boarding->pricingIntents->retrieve(
            '5',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.pricing_intents.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/pricing-intents/5",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'boarding.pricing_intents.update.0';
        $this->client->boarding->pricingIntents->update(
            '5',
            new UpdatePricingIntentsRequest([
                'body' => new PricingIntent50([
                    'country' => PricingAgreementUs50Country::Us->value,
                    'version' => PricingAgreementUs50Version::Five0->value,
                    'base' => new BaseUs([
                        'addressVerification' => 5,
                        'annualFee' => new BaseUsAnnualFee([
                            'billInMonth' => BaseUsAnnualFeeBillInMonth::June->value,
                            'amount' => 9900,
                        ]),
                        'regulatoryAssistanceProgram' => 15,
                        'pciNonCompliance' => 4995,
                        'merchantAdvantage' => 10,
                        'platinumSecurity' => BaseUsPlatinumSecurity::monthly(new BaseUsMonthly([])),
                        'maintenance' => 500,
                        'minimum' => 100,
                        'voiceAuthorization' => 95,
                        'chargeback' => 2500,
                        'retrieval' => 1500,
                        'batch' => 1500,
                        'earlyTermination' => 57500,
                    ]),
                    'processor' => new PricingAgreementUs50Processor([
                        'card' => PricingAgreementUs50ProcessorCard::interchangePlus(new InterchangePlus([
                            'fees' => new InterchangePlusFees([
                                'mastercardVisaDiscover' => new ProcessorFee([]),
                            ]),
                        ])),
                        'ach' => new Ach([
                            'fees' => new AchFees([
                                'transaction' => 50,
                                'batch' => 5,
                                'returns' => 400,
                                'unauthorizedReturn' => 1999,
                                'statement' => 800,
                                'monthlyMinimum' => 20000,
                                'accountVerification' => 10,
                                'discountRateUnder10000' => 5.25,
                                'discountRateAbove10000' => 10,
                            ]),
                        ]),
                    ]),
                    'gateway' => new GatewayUs50([
                        'fees' => new GatewayUs50Fees([
                            'monthly' => 2000,
                            'setup' => 5000,
                            'perTransaction' => 2000,
                            'perDeviceMonthly' => 10,
                        ]),
                    ]),
                    'services' => [
                        ServiceUs50::hardwareAdvantagePlan(new HardwareAdvantagePlan([
                            'enabled' => true,
                        ])),
                    ],
                    'key' => 'Your-Unique-Identifier',
                    'metadata' => [
                        'yourCustomField' => 'abc123',
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.pricing_intents.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/pricing-intents/5",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'boarding.pricing_intents.delete.0';
        $this->client->boarding->pricingIntents->delete(
            '5',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.pricing_intents.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/pricing-intents/5",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'boarding.pricing_intents.partially_update.0';
        $this->client->boarding->pricingIntents->partiallyUpdate(
            '5',
            new PartiallyUpdatePricingIntentsRequest([
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
                    'X-Test-Id' => 'boarding.pricing_intents.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/pricing-intents/5",
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
