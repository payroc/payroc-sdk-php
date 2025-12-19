<?php

namespace Payroc\Reporting;

use Payroc\Reporting\Settlement\SettlementClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class ReportingClient
{
    /**
     * @var SettlementClient $settlement
     */
    public SettlementClient $settlement;

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
        $this->settlement = new SettlementClient($this->client, $this->environment);
    }
}
