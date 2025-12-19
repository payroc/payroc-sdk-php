<?php

namespace Payroc\Notifications;

use Payroc\Notifications\EventSubscriptions\EventSubscriptionsClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class NotificationsClient
{
    /**
     * @var EventSubscriptionsClient $eventSubscriptions
     */
    public EventSubscriptionsClient $eventSubscriptions;

    /**
     * @var array{
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @var Environments $environment
     */
    private Environments $environment;

    /**
     * @param RawClient $client
     * @param Environments $environment
     */
    public function __construct(
        RawClient $client,
        Environments $environment,
    ) {
        $this->client = $client;
        $this->environment = $environment;
        $this->options = [];
        $this->eventSubscriptions = new EventSubscriptionsClient($this->client, $this->environment);
    }
}
