<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Auth\Requests\RetrieveTokenAuthRequest;
use Payroc\Environments;

class AuthWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieveToken(): void {
        $testId = 'auth.retrieve_token.0';
        $this->client->auth->retrieveToken(
            new RetrieveTokenAuthRequest([
                'apiKey' => 'x-api-key',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'auth.retrieve_token.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/authorize",
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
