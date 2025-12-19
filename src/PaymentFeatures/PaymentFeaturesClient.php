<?php

namespace Payroc\PaymentFeatures;

use Payroc\PaymentFeatures\Cards\CardsClient;
use Payroc\PaymentFeatures\Bank\BankClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class PaymentFeaturesClient
{
    /**
     * @var CardsClient $cards
     */
    public CardsClient $cards;

    /**
     * @var BankClient $bank
     */
    public BankClient $bank;

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
        $this->cards = new CardsClient($this->client, $this->environment);
        $this->bank = new BankClient($this->client, $this->environment);
    }
}
