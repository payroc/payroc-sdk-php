<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\PaymentLinks\SharingEvents\Requests\ListSharingEventsRequest;
use Payroc\PaymentLinks\SharingEvents\Requests\ShareSharingEventsRequest;
use Payroc\Types\PaymentLinkEmailShareEvent;
use Payroc\Types\PaymentLinkEmailShareEventSharingMethod;
use Payroc\Types\PaymentLinkEmailRecipient;
use Payroc\Environments;

class PaymentLinksSharingEventsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'payment_links.sharing_events.list_.0';
        $this->client->paymentLinks->sharingEvents->list(
            'JZURRJBUPS',
            new ListSharingEventsRequest([
                'recipientName' => 'Sarah Hazel Hopper',
                'recipientEmail' => 'sarah.hopper@example.com',
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.sharing_events.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/payment-links/JZURRJBUPS/sharing-events",
            ['recipientName' => 'Sarah Hazel Hopper', 'recipientEmail' => 'sarah.hopper@example.com', 'before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testShare(): void {
        $testId = 'payment_links.sharing_events.share.0';
        $this->client->paymentLinks->sharingEvents->share(
            'JZURRJBUPS',
            new ShareSharingEventsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new PaymentLinkEmailShareEvent([
                    'sharingMethod' => PaymentLinkEmailShareEventSharingMethod::Email->value,
                    'merchantCopy' => true,
                    'message' => <<<EOT
Dear Sarah,

Your insurance is expiring this month.
Please, pay the renewal fee by the end of the month to renew it.

EOT,
                    'recipients' => [
                        new PaymentLinkEmailRecipient([
                            'name' => 'Sarah Hazel Hopper',
                            'email' => 'sarah.hopper@example.com',
                        ]),
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'payment_links.sharing_events.share.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/payment-links/JZURRJBUPS/sharing-events",
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
