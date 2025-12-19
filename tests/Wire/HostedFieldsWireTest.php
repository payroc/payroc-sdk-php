<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\HostedFields\Requests\HostedFieldsCreateSessionRequest;
use Payroc\HostedFields\Types\HostedFieldsCreateSessionRequestScenario;
use Payroc\Environments;

class HostedFieldsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testCreate(): void {
        $testId = 'hosted_fields.create.0';
        $this->client->hostedFields->create(
            '1234001',
            new HostedFieldsCreateSessionRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'libVersion' => '1.1.0.123456',
                'scenario' => HostedFieldsCreateSessionRequestScenario::Payment->value,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'hosted_fields.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/hosted-fields-sessions",
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
