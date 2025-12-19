<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Boarding\Contacts\Requests\UpdateContactsRequest;
use Payroc\Types\Contact;
use Payroc\Types\ContactType;
use Payroc\Types\Identifier;
use Payroc\Types\IdentifierType;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Environments;

class BoardingContactsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.contacts.retrieve.0';
        $this->client->boarding->contacts->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.contacts.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/contacts/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'boarding.contacts.update.0';
        $this->client->boarding->contacts->update(
            1,
            new UpdateContactsRequest([
                'body' => new Contact([
                    'type' => ContactType::Manager->value,
                    'firstName' => 'Jane',
                    'middleName' => 'Helen',
                    'lastName' => 'Doe',
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
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.contacts.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/contacts/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'boarding.contacts.delete.0';
        $this->client->boarding->contacts->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.contacts.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/contacts/1",
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
