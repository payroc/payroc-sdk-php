<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PayrocCloud\SignatureInstructions\Requests\SignatureInstructionRequest;
use Payroc\Environments;

class PayrocCloudSignatureInstructionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testSubmit(): void {
        $testId = 'payroc_cloud.signature_instructions.submit.0';
        $this->client->payrocCloud->signatureInstructions->submit(
            '1850010868',
            new SignatureInstructionRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.signature_instructions.submit.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/devices/1850010868/signature-instructions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'payroc_cloud.signature_instructions.retrieve.0';
        $this->client->payrocCloud->signatureInstructions->retrieve(
            'a37439165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.signature_instructions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/signature-instructions/a37439165d134678a9100ebba3b29597",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'payroc_cloud.signature_instructions.delete.0';
        $this->client->payrocCloud->signatureInstructions->delete(
            'a37439165d134678a9100ebba3b29597',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.signature_instructions.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/signature-instructions/a37439165d134678a9100ebba3b29597",
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
