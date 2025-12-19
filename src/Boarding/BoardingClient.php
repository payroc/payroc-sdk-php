<?php

namespace Payroc\Boarding;

use Payroc\Boarding\Owners\OwnersClient;
use Payroc\Boarding\PricingIntents\PricingIntentsClient;
use Payroc\Boarding\MerchantPlatforms\MerchantPlatformsClient;
use Payroc\Boarding\ProcessingAccounts\ProcessingAccountsClient;
use Payroc\Boarding\ProcessingTerminals\ProcessingTerminalsClient;
use Payroc\Boarding\Contacts\ContactsClient;
use Payroc\Boarding\TerminalOrders\TerminalOrdersClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class BoardingClient
{
    /**
     * @var OwnersClient $owners
     */
    public OwnersClient $owners;

    /**
     * @var PricingIntentsClient $pricingIntents
     */
    public PricingIntentsClient $pricingIntents;

    /**
     * @var MerchantPlatformsClient $merchantPlatforms
     */
    public MerchantPlatformsClient $merchantPlatforms;

    /**
     * @var ProcessingAccountsClient $processingAccounts
     */
    public ProcessingAccountsClient $processingAccounts;

    /**
     * @var ProcessingTerminalsClient $processingTerminals
     */
    public ProcessingTerminalsClient $processingTerminals;

    /**
     * @var ContactsClient $contacts
     */
    public ContactsClient $contacts;

    /**
     * @var TerminalOrdersClient $terminalOrders
     */
    public TerminalOrdersClient $terminalOrders;

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
        $this->owners = new OwnersClient($this->client, $this->environment);
        $this->pricingIntents = new PricingIntentsClient($this->client, $this->environment);
        $this->merchantPlatforms = new MerchantPlatformsClient($this->client, $this->environment);
        $this->processingAccounts = new ProcessingAccountsClient($this->client, $this->environment);
        $this->processingTerminals = new ProcessingTerminalsClient($this->client, $this->environment);
        $this->contacts = new ContactsClient($this->client, $this->environment);
        $this->terminalOrders = new TerminalOrdersClient($this->client, $this->environment);
    }
}
