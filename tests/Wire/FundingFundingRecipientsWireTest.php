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
use Payroc\Types\ContactMethodPhone;
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
use Payroc\Types\FundingRecipientOwnersItem;
use Payroc\Types\FundingRecipientOwnersItemLink;
use Payroc\Types\FundingRecipientFundingAccountsItem;
use Payroc\Types\FundingRecipientFundingAccountsItemStatus;
use Payroc\Types\FundingRecipientFundingAccountsItemLink;
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
        $response = $this->client->funding->fundingRecipients->list(
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
        foreach ($response as $item) {
            break;
        }
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
                'taxId' => '12-3456789',
                'doingBusinessAs' => 'Pizza Doe',
                'address' => new Address([
                    'address1' => '1 Example Ave.',
                    'address2' => 'Example Address Line 2',
                    'address3' => 'Example Address Line 3',
                    'city' => 'Chicago',
                    'state' => 'Illinois',
                    'country' => 'US',
                    'postalCode' => '60056',
                ]),
                'contactMethods' => [
                    ContactMethod::email(new ContactMethodEmail([
                        'value' => 'jane.doe@example.com',
                    ])),
                    ContactMethod::phone(new ContactMethodPhone([
                        'value' => '2025550164',
                    ])),
                ],
                'metadata' => [
                    'yourCustomField' => 'abc123',
                ],
                'owners' => [
                    new Owner([
                        'firstName' => 'Jane',
                        'middleName' => 'Helen',
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
                                'value' => '000-00-4320',
                            ]),
                        ],
                        'contactMethods' => [
                            ContactMethod::email(new ContactMethodEmail([
                                'value' => 'jane.doe@example.com',
                            ])),
                            ContactMethod::phone(new ContactMethodPhone([
                                'value' => '2025550164',
                            ])),
                        ],
                        'relationship' => new OwnerRelationship([
                            'equityPercentage' => 48.5,
                            'title' => 'CFO',
                            'isControlProng' => true,
                            'isAuthorizedSignatory' => false,
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
                    'taxId' => '12-3456789',
                    'doingBusinessAs' => 'Doe Hot Dogs',
                    'address' => new Address([
                        'address1' => '2 Example Ave.',
                        'address2' => 'Example Address Line 2',
                        'address3' => 'Example Address Line 3',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                        ContactMethod::phone(new ContactMethodPhone([
                            'value' => '2025550164',
                        ])),
                    ],
                    'metadata' => [
                        'responsiblePerson' => 'Jane Doe',
                    ],
                    'owners' => [
                        new FundingRecipientOwnersItem([
                            'ownerId' => 12346,
                            'link' => new FundingRecipientOwnersItemLink([
                                'rel' => 'owner',
                                'href' => 'https://api.payroc.com/v1/owners/12346',
                                'method' => 'get',
                            ]),
                        ]),
                    ],
                    'fundingAccounts' => [
                        new FundingRecipientFundingAccountsItem([
                            'fundingAccountId' => 124,
                            'status' => FundingRecipientFundingAccountsItemStatus::Approved->value,
                            'link' => new FundingRecipientFundingAccountsItemLink([
                                'rel' => 'fundingAccount',
                                'href' => 'https://api.payroc.com/v1/funding-accounts/124',
                                'method' => 'get',
                            ]),
                        ]),
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
                    'type' => FundingAccountType::Savings->value,
                    'use' => FundingAccountUse::Credit->value,
                    'nameOnAccount' => 'Fred Nerk',
                    'paymentMethods' => [
                        PaymentMethodsItem::ach(new PaymentMethodAch([])),
                    ],
                    'metadata' => [
                        'responsiblePerson' => 'Jane Doe',
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
                    'firstName' => 'Fred',
                    'middleName' => 'Jim',
                    'lastName' => 'Nerk',
                    'dateOfBirth' => new DateTime('1980-01-19'),
                    'address' => new Address([
                        'address1' => '2 Example Ave.',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'identifiers' => [
                        new Identifier([
                            'type' => IdentifierType::NationalId->value,
                            'value' => '000-00-9876',
                        ]),
                    ],
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                        ContactMethod::phone(new ContactMethodPhone([
                            'value' => '2025550164',
                        ])),
                    ],
                    'relationship' => new OwnerRelationship([
                        'equityPercentage' => 51.5,
                        'title' => 'CEO',
                        'isControlProng' => false,
                        'isAuthorizedSignatory' => true,
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
        $wiremockUrl = getenv('WIREMOCK_URL') ?: 'http://localhost:8080';
        $this->client = new PayrocClient(
            apiKey: 'test-apiKey',
            environment: Environments::custom($wiremockUrl, $wiremockUrl),
        );
    }
}
