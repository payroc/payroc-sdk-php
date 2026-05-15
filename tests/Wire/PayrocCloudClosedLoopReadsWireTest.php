<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Environments;

class PayrocCloudClosedLoopReadsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieve(): void {
        $testId = 'payroc_cloud.closed_loop_reads.retrieve.0';
        $this->client->payrocCloud->closedLoopReads->retrieve(
            'JDN4ILZB0T',
            [
                'headers' => [
                    'X-Test-Id' => 'payroc_cloud.closed_loop_reads.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/closed-loop-reads/JDN4ILZB0T",
            null,
            1
        );
    }

    /**
     */
    protected function setUp(): void {
        parent::setUp();
        $wiremockUrl = getenv('WIREMOCK_URL') ?: 'http://localhost:8080';
        $this->client = new PayrocClient(
            apiKey: 'test-apiKey',
            environment: Environments::custom($wiremockUrl, $wiremockUrl),
        );
    }
}
