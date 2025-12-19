<?php

namespace Payroc\BankTransferPayments;

use Payroc\BankTransferPayments\Payments\PaymentsClient;
use Payroc\BankTransferPayments\Refunds\RefundsClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class BankTransferPaymentsClient
{
    /**
     * @var PaymentsClient $payments
     */
    public PaymentsClient $payments;

    /**
     * @var RefundsClient $refunds
     */
    public RefundsClient $refunds;

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
        $this->payments = new PaymentsClient($this->client, $this->environment);
        $this->refunds = new RefundsClient($this->client, $this->environment);
    }
}
