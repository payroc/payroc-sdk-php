<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PayrocCloud\RefundInstructions\Requests\RefundInstructionRequest;
use Payroc\Types\RefundInstructionOrder;
use Payroc\Types\Currency;
use Payroc\Types\CustomizationOptions;
use Payroc\Types\CustomizationOptionsEntryMethod;
use Payroc\Environments;

class PayrocCloudRefundInstructionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testSubmit(): void {
        $testId = 'payroc_cloud.refund_instructions.submit.0';
        $this->client->payrocCloud->refundInstructions->submit(
            '1850010868',
            new RefundInstructionRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'operator' => 'Jane',
                'processingTerminalId' => '1234001',
                'order' => new RefundInstructionOrder([
                    'orderId' => 'OrderRef6543',
                    'description' => 'Refund for order OrderRef6543',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                ]),
                'customizationOptions' => new CustomizationOptions([
                    'entryMethod' => CustomizationOptionsEntryMethod::ManualEntry->value,
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.refund_instructions.submit.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/devices/1850010868/refund-instructions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'payroc_cloud.refund_instructions.retrieve.0';
        $this->client->payrocCloud->refundInstructions->retrieve(
            'a37439165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.refund_instructions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/refund-instructions/a37439165d134678a9100ebba3b29597",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'payroc_cloud.refund_instructions.delete.0';
        $this->client->payrocCloud->refundInstructions->delete(
            'a37439165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.refund_instructions.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/refund-instructions/a37439165d134678a9100ebba3b29597",
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
