<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Funding\FundingRecipients\Requests\ListFundingRecipientsRequest;
use Payroc\Funding\FundingRecipients\Requests\CreateFundingRecipient;
use Payroc\Funding\FundingRecipients\Types\CreateFundingRecipientRecipientType;
use Payroc\Types\Address;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Types\Owner;
use DateTime;
use Payroc\Types\Identifier;
use Payroc\Types\IdentifierType;
use Payroc\Types\OwnerRelationship;
use Payroc\Types\FundingAccount;
use Payroc\Types\FundingAccountType;
use Payroc\Types\FundingAccountUse;
use Payroc\Types\PaymentMethodsItem;
use Payroc\Types\PaymentMethodAch;
use Payroc\Funding\FundingRecipients\Requests\UpdateFundingRecipientsRequest;
use Payroc\Types\FundingRecipient;
use Payroc\Types\FundingRecipientRecipientType;
use Payroc\Funding\FundingRecipients\Requests\CreateAccountFundingRecipientsRequest;
use Payroc\Funding\FundingRecipients\Requests\CreateOwnerFundingRecipientsRequest;
use Payroc\Environments;

class FundingFundingRecipientsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'funding.funding_recipients.list_.0';
        $this->client->funding->fundingRecipients->list(
            new ListFundingRecipientsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-recipients",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'funding.funding_recipients.create.0';
        $this->client->funding->fundingRecipients->create(
            new CreateFundingRecipient([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'recipientType' => CreateFundingRecipientRecipientType::PrivateCorporation->value,
                'taxId' => '123456789',
                'doingBusinessAs' => 'doingBusinessAs',
                'address' => new Address([
                    'address1' => '1 Example Ave.',
                    'city' => 'Chicago',
                    'state' => 'Illinois',
                    'country' => 'US',
                    'postalCode' => '60056',
                ]),
                'contactMethods' => [
                    ContactMethod::email(new ContactMethodEmail([
                        'value' => 'jane.doe@example.com',
                    ])),
                ],
                'owners' => [
                    new Owner([
                        'firstName' => 'Jane',
                        'lastName' => 'Doe',
                        'dateOfBirth' => new DateTime('1964-03-22'),
                        'address' => new Address([
                            'address1' => '1 Example Ave.',
                            'city' => 'Chicago',
                            'state' => 'Illinois',
                            'country' => 'US',
                            'postalCode' => '60056',
                        ]),
                        'identifiers' => [
                            new Identifier([
                                'type' => IdentifierType::NationalId->value,
                                'value' => 'xxxxx4320',
                            ]),
                        ],
                        'contactMethods' => [
                            ContactMethod::email(new ContactMethodEmail([
                                'value' => 'jane.doe@example.com',
                            ])),
                        ],
                        'relationship' => new OwnerRelationship([
                            'isControlProng' => true,
                        ]),
                    ]),
                ],
                'fundingAccounts' => [
                    new FundingAccount([
                        'type' => FundingAccountType::Checking->value,
                        'use' => FundingAccountUse::Credit->value,
                        'nameOnAccount' => 'Jane Doe',
                        'paymentMethods' => [
                            PaymentMethodsItem::ach(new PaymentMethodAch([])),
                        ],
                    ]),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/funding-recipients",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'funding.funding_recipients.retrieve.0';
        $this->client->funding->fundingRecipients->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-recipients/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'funding.funding_recipients.update.0';
        $this->client->funding->fundingRecipients->update(
            1,
            new UpdateFundingRecipientsRequest([
                'body' => new FundingRecipient([
                    'recipientType' => FundingRecipientRecipientType::PrivateCorporation->value,
                    'taxId' => '123456789',
                    'doingBusinessAs' => 'doingBusinessAs',
                    'address' => new Address([
                        'address1' => '1 Example Ave.',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/funding-recipients/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'funding.funding_recipients.delete.0';
        $this->client->funding->fundingRecipients->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/funding-recipients/1",
            null,
            1
        );
    }

    /**
     */
    public function testListAccounts(): void {
        $testId = 'funding.funding_recipients.list_accounts.0';
        $this->client->funding->fundingRecipients->listAccounts(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.list_accounts.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-recipients/1/funding-accounts",
            null,
            1
        );
    }

    /**
     */
    public function testCreateAccount(): void {
        $testId = 'funding.funding_recipients.create_account.0';
        $this->client->funding->fundingRecipients->createAccount(
            1,
            new CreateAccountFundingRecipientsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new FundingAccount([
                    'type' => FundingAccountType::Checking->value,
                    'use' => FundingAccountUse::Credit->value,
                    'nameOnAccount' => 'Jane Doe',
                    'paymentMethods' => [
                        PaymentMethodsItem::ach(new PaymentMethodAch([])),
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.create_account.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/funding-recipients/1/funding-accounts",
            null,
            1
        );
    }

    /**
     */
    public function testListOwners(): void {
        $testId = 'funding.funding_recipients.list_owners.0';
        $this->client->funding->fundingRecipients->listOwners(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.list_owners.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-recipients/1/owners",
            null,
            1
        );
    }

    /**
     */
    public function testCreateOwner(): void {
        $testId = 'funding.funding_recipients.create_owner.0';
        $this->client->funding->fundingRecipients->createOwner(
            1,
            new CreateOwnerFundingRecipientsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new Owner([
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'dateOfBirth' => new DateTime('1964-03-22'),
                    'address' => new Address([
                        'address1' => '1 Example Ave.',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'identifiers' => [
                        new Identifier([
                            'type' => IdentifierType::NationalId->value,
                            'value' => 'xxxxx4320',
                        ]),
                    ],
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                    'relationship' => new OwnerRelationship([
                        'isControlProng' => true,
                    ]),
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_recipients.create_owner.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/funding-recipients/1/owners",
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
