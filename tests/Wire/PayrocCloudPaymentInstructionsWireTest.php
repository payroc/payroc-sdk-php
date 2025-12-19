<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PayrocCloud\PaymentInstructions\Requests\PaymentInstructionRequest;
use Payroc\Types\PaymentInstructionOrder;
use Payroc\Types\Currency;
use Payroc\Types\CustomizationOptions;
use Payroc\Types\CustomizationOptionsEntryMethod;
use Payroc\Environments;

class PayrocCloudPaymentInstructionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testSubmit(): void {
        $testId = 'payroc_cloud.payment_instructions.submit.0';
        $this->client->payrocCloud->paymentInstructions->submit(
            '1850010868',
            new PaymentInstructionRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'operator' => 'Jane',
                'processingTerminalId' => '1234001',
                'order' => new PaymentInstructionOrder([
                    'orderId' => 'OrderRef6543',
                    'amount' => 4999,
                    'currency' => Currency::Usd->value,
                ]),
                'customizationOptions' => new CustomizationOptions([
                    'entryMethod' => CustomizationOptionsEntryMethod::DeviceRead->value,
                ]),
                'autoCapture' => true,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.payment_instructions.submit.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/devices/1850010868/payment-instructions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'payroc_cloud.payment_instructions.retrieve.0';
        $this->client->payrocCloud->paymentInstructions->retrieve(
            'e743a9165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.payment_instructions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/payment-instructions/e743a9165d134678a9100ebba3b29597",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'payroc_cloud.payment_instructions.delete.0';
        $this->client->payrocCloud->paymentInstructions->delete(
            'e743a9165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.payment_instructions.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/payment-instructions/e743a9165d134678a9100ebba3b29597",
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
