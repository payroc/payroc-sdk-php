<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Tokenization\SecureTokens\Requests\ListSecureTokensRequest;
use Payroc\Tokenization\SecureTokens\Requests\TokenizationRequest;
use Payroc\Tokenization\SecureTokens\Types\TokenizationRequestMitAgreement;
use Payroc\Types\Customer;
use DateTime;
use Payroc\Types\Address;
use Payroc\Types\Shipping;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Types\CustomerNotificationLanguage;
use Payroc\Types\IpAddress;
use Payroc\Types\IpAddressType;
use Payroc\Tokenization\SecureTokens\Types\TokenizationRequestSource;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\Types\CustomField;
use Payroc\Tokenization\SecureTokens\Requests\PartiallyUpdateSecureTokensRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\Tokenization\SecureTokens\Requests\UpdateAccountSecureTokensRequest;
use Payroc\Types\AccountUpdate;
use Payroc\Types\SingleUseTokenAccountUpdate;
use Payroc\Environments;

class TokenizationSecureTokensWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'tokenization.secure_tokens.list_.0';
        $this->client->tokenization->secureTokens->list(
            '1234001',
            new ListSecureTokensRequest([
                'secureTokenId' => 'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa',
                'customerName' => 'Sarah%20Hazel%20Hopper',
                'phone' => '2025550165',
                'email' => 'sarah.hopper@example.com',
                'token' => '296753123456',
                'first6' => '453985',
                'last4' => '7062',
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/secure-tokens",
            ['secureTokenId' => 'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa', 'customerName' => 'Sarah%20Hazel%20Hopper', 'phone' => '2025550165', 'email' => 'sarah.hopper@example.com', 'token' => '296753123456', 'first6' => '453985', 'last4' => '7062', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'tokenization.secure_tokens.create.0';
        $this->client->tokenization->secureTokens->create(
            '1234001',
            new TokenizationRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'operator' => 'Jane',
                'mitAgreement' => TokenizationRequestMitAgreement::Unscheduled->value,
                'customer' => new Customer([
                    'firstName' => 'Sarah',
                    'lastName' => 'Hopper',
                    'dateOfBirth' => new DateTime('1990-07-15'),
                    'referenceNumber' => 'Customer-12',
                    'billingAddress' => new Address([
                        'address1' => '1 Example Ave.',
                        'address2' => 'Example Address Line 2',
                        'address3' => 'Example Address Line 3',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'shippingAddress' => new Shipping([
                        'recipientName' => 'Sarah Hopper',
                        'address' => new Address([
                            'address1' => '1 Example Ave.',
                            'address2' => 'Example Address Line 2',
                            'address3' => 'Example Address Line 3',
                            'city' => 'Chicago',
                            'state' => 'Illinois',
                            'country' => 'US',
                            'postalCode' => '60056',
                        ]),
                    ]),
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                    'notificationLanguage' => CustomerNotificationLanguage::En->value,
                ]),
                'ipAddress' => new IpAddress([
                    'type' => IpAddressType::Ipv4->value,
                    'value' => '104.18.24.203',
                ]),
                'source' => TokenizationRequestSource::card(new CardPayload([
                    'cardDetails' => CardPayloadCardDetails::raw(new RawCardDetails([
                        'device' => new Device([
                            'model' => DeviceModel::BbposChp->value,
                            'serialNumber' => '1850010868',
                        ]),
                        'rawData' => 'A1B2C3D4E5F67890ABCD1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
                    ])),
                ])),
                'customFields' => [
                    new CustomField([
                        'name' => 'yourCustomField',
                        'value' => 'abc123',
                    ]),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/secure-tokens",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'tokenization.secure_tokens.retrieve.0';
        $this->client->tokenization->secureTokens->retrieve(
            '1234001',
            'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa',
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-terminals/1234001/secure-tokens/MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'tokenization.secure_tokens.delete.0';
        $this->client->tokenization->secureTokens->delete(
            '1234001',
            'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa',
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/processing-terminals/1234001/secure-tokens/MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'tokenization.secure_tokens.partially_update.0';
        $this->client->tokenization->secureTokens->partiallyUpdate(
            '1234001',
            'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa',
            new PartiallyUpdateSecureTokensRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => [
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/processing-terminals/1234001/secure-tokens/MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa",
            null,
            1
        );
    }

    /**
     */
    public function testUpdateAccount(): void {
        $testId = 'tokenization.secure_tokens.update_account.0';
        $this->client->tokenization->secureTokens->updateAccount(
            '1234001',
            'MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa',
            new UpdateAccountSecureTokensRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => AccountUpdate::singleUseToken(new SingleUseTokenAccountUpdate([
                    'token' => 'abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234567890',
                ])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'tokenization.secure_tokens.update_account.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-terminals/1234001/secure-tokens/MREF_abc1de23-f4a5-6789-bcd0-12e345678901fa/update-account",
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
