<?php

namespace Payroc\Tokenization;

use Payroc\Tokenization\SecureTokens\SecureTokensClient;
use Payroc\Tokenization\SingleUseTokens\SingleUseTokensClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class TokenizationClient
{
    /**
     * @var SecureTokensClient $secureTokens
     */
    public SecureTokensClient $secureTokens;

    /**
     * @var SingleUseTokensClient $singleUseTokens
     */
    public SingleUseTokensClient $singleUseTokens;

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
        $this->secureTokens = new SecureTokensClient($this->client, $this->environment);
        $this->singleUseTokens = new SingleUseTokensClient($this->client, $this->environment);
    }
}
