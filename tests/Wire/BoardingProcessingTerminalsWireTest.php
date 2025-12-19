<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Environments;

class BoardingProcessingTerminalsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.processing_terminals.retrieve.0';
        $this->client->boarding->processingTerminals->retrieve(
            '1234001',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_terminals.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieveHostConfiguration(): void {
        $testId = 'boarding.processing_terminals.retrieve_host_configuration.0';
        $this->client->boarding->processingTerminals->retrieveHostConfiguration(
            '1234001',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_terminals.retrieve_host_configuration.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/host-configurations",
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
