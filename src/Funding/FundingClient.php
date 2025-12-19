<?php

namespace Payroc\Funding;

use Payroc\Funding\FundingRecipients\FundingRecipientsClient;
use Payroc\Funding\FundingAccounts\FundingAccountsClient;
use Payroc\Funding\FundingInstructions\FundingInstructionsClient;
use Payroc\Funding\FundingActivity\FundingActivityClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class FundingClient
{
    /**
     * @var FundingRecipientsClient $fundingRecipients
     */
    public FundingRecipientsClient $fundingRecipients;

    /**
     * @var FundingAccountsClient $fundingAccounts
     */
    public FundingAccountsClient $fundingAccounts;

    /**
     * @var FundingInstructionsClient $fundingInstructions
     */
    public FundingInstructionsClient $fundingInstructions;

    /**
     * @var FundingActivityClient $fundingActivity
     */
    public FundingActivityClient $fundingActivity;

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
        $this->fundingRecipients = new FundingRecipientsClient($this->client, $this->environment);
        $this->fundingAccounts = new FundingAccountsClient($this->client, $this->environment);
        $this->fundingInstructions = new FundingInstructionsClient($this->client, $this->environment);
        $this->fundingActivity = new FundingActivityClient($this->client, $this->environment);
    }
}
