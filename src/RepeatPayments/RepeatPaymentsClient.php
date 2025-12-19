<?php

namespace Payroc\RepeatPayments;

use Payroc\RepeatPayments\PaymentPlans\PaymentPlansClient;
use Payroc\RepeatPayments\Subscriptions\SubscriptionsClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class RepeatPaymentsClient
{
    /**
     * @var PaymentPlansClient $paymentPlans
     */
    public PaymentPlansClient $paymentPlans;

    /**
     * @var SubscriptionsClient $subscriptions
     */
    public SubscriptionsClient $subscriptions;

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
        $this->paymentPlans = new PaymentPlansClient($this->client, $this->environment);
        $this->subscriptions = new SubscriptionsClient($this->client, $this->environment);
    }
}
