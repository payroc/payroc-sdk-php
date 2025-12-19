<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Notifications\EventSubscriptions\Requests\ListEventSubscriptionsRequest;
use Payroc\Notifications\EventSubscriptions\Types\ListEventSubscriptionsRequestStatus;
use Payroc\Notifications\EventSubscriptions\Requests\CreateEventSubscriptionsRequest;
use Payroc\Types\EventSubscription;
use Payroc\Types\Notification;
use Payroc\Types\Webhook;
use Payroc\Notifications\EventSubscriptions\Requests\UpdateEventSubscriptionsRequest;
use Payroc\Notifications\EventSubscriptions\Requests\PartiallyUpdateEventSubscriptionsRequest;
use Payroc\Types\PatchDocument;
use Payroc\Types\PatchRemove;
use Payroc\Environments;

class NotificationsEventSubscriptionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'notifications.event_subscriptions.list_.0';
        $this->client->notifications->eventSubscriptions->list(
            new ListEventSubscriptionsRequest([
                'status' => ListEventSubscriptionsRequestStatus::Registered->value,
                'event' => 'processingAccount.status.changed',
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/event-subscriptions",
            ['status' => 'registered', 'event' => 'processingAccount.status.changed'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'notifications.event_subscriptions.create.0';
        $this->client->notifications->eventSubscriptions->create(
            new CreateEventSubscriptionsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new EventSubscription([
                    'enabled' => true,
                    'eventTypes' => [
                        'processingAccount.status.changed',
                    ],
                    'notifications' => [
                        Notification::webhook(new Webhook([
                            'uri' => 'https://my-server/notification/endpoint',
                            'secret' => 'aBcD1234eFgH5678iJkL9012mNoP3456',
                            'supportEmailAddress' => 'supportEmailAddress',
                        ])),
                    ],
                    'metadata' => [
                        'yourCustomField' => "abc123",
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/event-subscriptions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'notifications.event_subscriptions.retrieve.0';
        $this->client->notifications->eventSubscriptions->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/event-subscriptions/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'notifications.event_subscriptions.update.0';
        $this->client->notifications->eventSubscriptions->update(
            1,
            new UpdateEventSubscriptionsRequest([
                'body' => new EventSubscription([
                    'enabled' => true,
                    'eventTypes' => [
                        'processingAccount.status.changed',
                    ],
                    'notifications' => [
                        Notification::webhook(new Webhook([
                            'uri' => 'https://my-server/notification/endpoint',
                            'secret' => 'aBcD1234eFgH5678iJkL9012mNoP3456',
                            'supportEmailAddress' => 'supportEmailAddress',
                        ])),
                    ],
                    'metadata' => [
                        'yourCustomField' => "abc123",
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/event-subscriptions/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'notifications.event_subscriptions.delete.0';
        $this->client->notifications->eventSubscriptions->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/event-subscriptions/1",
            null,
            1
        );
    }

    /**
     */
    public function testPartiallyUpdate(): void {
        $testId = 'notifications.event_subscriptions.partially_update.0';
        $this->client->notifications->eventSubscriptions->partiallyUpdate(
            1,
            new PartiallyUpdateEventSubscriptionsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => [
                    PatchDocument::remove(new PatchRemove([
                        'path' => 'path',
                    ])),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'notifications.event_subscriptions.partially_update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PATCH",
            "/event-subscriptions/1",
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
