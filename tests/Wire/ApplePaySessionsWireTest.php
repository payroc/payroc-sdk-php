<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\ApplePaySessions\Requests\ApplePaySessions;
use Payroc\Environments;

class ApplePaySessionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testCreate(): void {
        $testId = 'apple_pay_sessions.create.0';
        $this->client->applePaySessions->create(
            '1234001',
            new ApplePaySessions([
                'appleDomainId' => 'DUHDZJHGYY',
                'appleValidationUrl' => 'https://apple-pay-gateway.apple.com/paymentservices/startSession',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'apple_pay_sessions.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/apple-pay-sessions",
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
