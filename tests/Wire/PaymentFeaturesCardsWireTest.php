<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PaymentFeatures\Cards\Requests\CardVerificationRequest;
use Payroc\PaymentFeatures\Cards\Types\CardVerificationRequestCard;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\PaymentFeatures\Cards\Requests\BalanceInquiry;
use Payroc\Types\Currency;
use Payroc\PaymentFeatures\Cards\Types\BalanceInquiryCard;
use Payroc\PaymentFeatures\Cards\Requests\BinLookup;
use Payroc\PaymentFeatures\Cards\Types\BinLookupCard;
use Payroc\PaymentFeatures\Cards\Requests\FxRateInquiry;
use Payroc\PaymentFeatures\Cards\Types\FxRateInquiryChannel;
use Payroc\PaymentFeatures\Cards\Types\FxRateInquiryPaymentMethod;
use Payroc\Environments;

class PaymentFeaturesCardsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testVerifyCard(): void {
        $testId = 'payment_features.cards.verify_card.0';
        $this->client->paymentFeatures->cards->verifyCard(
            new CardVerificationRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
                'operator' => 'Jane',
                'card' => CardVerificationRequestCard::card(new CardPayload([
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
                    'X-Test-Id' => 'payment_features.cards.verify_card.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/cards/verify",
            null,
            1
        );
    }

    /**
     */
    public function testViewEbtBalance(): void {
        $testId = 'payment_features.cards.view_ebt_balance.0';
        $this->client->paymentFeatures->cards->viewEbtBalance(
            new BalanceInquiry([
                'processingTerminalId' => '1234001',
                'operator' => 'Jane',
                'currency' => Currency::Usd->value,
                'card' => BalanceInquiryCard::card(new CardPayload([
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
                    'X-Test-Id' => 'payment_features.cards.view_ebt_balance.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/cards/balance",
            null,
            1
        );
    }

    /**
     */
    public function testLookupBin(): void {
        $testId = 'payment_features.cards.lookup_bin.0';
        $this->client->paymentFeatures->cards->lookupBin(
            new BinLookup([
                'processingTerminalId' => '1234001',
                'card' => BinLookupCard::card(new CardPayload([
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
                    'X-Test-Id' => 'payment_features.cards.lookup_bin.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/cards/bin-lookup",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieveFxRates(): void {
        $testId = 'payment_features.cards.retrieve_fx_rates.0';
        $this->client->paymentFeatures->cards->retrieveFxRates(
            new FxRateInquiry([
                'channel' => FxRateInquiryChannel::Web->value,
                'processingTerminalId' => '1234001',
                'operator' => 'Jane',
                'baseAmount' => 10000,
                'baseCurrency' => Currency::Usd->value,
                'paymentMethod' => FxRateInquiryPaymentMethod::card(new CardPayload([
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
                    'X-Test-Id' => 'payment_features.cards.retrieve_fx_rates.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/fx-rates",
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
