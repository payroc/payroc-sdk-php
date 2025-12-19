<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Tokenization\SingleUseTokens\Requests\SingleUseTokenRequest;
use Payroc\Tokenization\SingleUseTokens\Types\SingleUseTokenRequestChannel;
use Payroc\Tokenization\SingleUseTokens\Types\SingleUseTokenRequestSource;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\Environments;

class TokenizationSingleUseTokensWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testCreate(): void {
        $testId = 'tokenization.single_use_tokens.create.0';
        $this->client->tokenization->singleUseTokens->create(
            '1234001',
            new SingleUseTokenRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'channel' => SingleUseTokenRequestChannel::Web->value,
                'operator' => 'Jane',
                'source' => SingleUseTokenRequestSource::card(new CardPayload([
                    'cardDetails' => CardPayloadCardDetails::raw(new RawCardDetails([
                        'device' => new Device([
                            'model' => DeviceModel::BbposChp->value,
                            'serialNumber' => '1850010868',
                        ]),
                        'rawData' => 'A1B2C3D4E5F67890ABCD1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
                    ])),
                ])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.single_use_tokens.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/single-use-tokens",
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
