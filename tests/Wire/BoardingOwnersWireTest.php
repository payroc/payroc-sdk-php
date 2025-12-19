<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Boarding\Owners\Requests\UpdateOwnersRequest;
use Payroc\Types\Owner;
use DateTime;
use Payroc\Types\Address;
use Payroc\Types\Identifier;
use Payroc\Types\IdentifierType;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Types\OwnerRelationship;
use Payroc\Environments;

class BoardingOwnersWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.owners.retrieve.0';
        $this->client->boarding->owners->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.owners.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/owners/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'boarding.owners.update.0';
        $this->client->boarding->owners->update(
            1,
            new UpdateOwnersRequest([
                'body' => new Owner([
                    'firstName' => 'Jane',
                    'middleName' => 'Helen',
                    'lastName' => 'Doe',
                    'dateOfBirth' => new DateTime('1964-03-22'),
                    'address' => new Address([
                        'address1' => '1 Example Ave.',
                        'address2' => 'Example Address Line 2',
                        'address3' => 'Example Address Line 3',
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
                    ],
                    'relationship' => new OwnerRelationship([
                        'equityPercentage' => 48.5,
                        'title' => 'CFO',
                        'isControlProng' => true,
                        'isAuthorizedSignatory' => false,
                    ]),
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.owners.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/owners/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'boarding.owners.delete.0';
        $this->client->boarding->owners->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.owners.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/owners/1",
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
