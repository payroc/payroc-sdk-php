<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PaymentFeatures\Bank\Requests\BankAccountVerificationRequest;
use Payroc\PaymentFeatures\Bank\Types\BankAccountVerificationRequestBankAccount;
use Payroc\Types\PadPayload;
use Payroc\Environments;

class PaymentFeaturesBankWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testVerify(): void {
        $testId = 'payment_features.bank.verify.0';
        $this->client->paymentFeatures->bank->verify(
            new BankAccountVerificationRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'processingTerminalId' => '1234001',
                'bankAccount' => BankAccountVerificationRequestBankAccount::pad(new PadPayload([
                    'nameOnAccount' => 'Sarah Hazel Hopper',
                    'accountNumber' => '1234567890',
                    'transitNumber' => '76543',
                    'institutionNumber' => '543',
                ])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_features.bank.verify.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/bank-accounts/verify",
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
