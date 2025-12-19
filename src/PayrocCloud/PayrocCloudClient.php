<?php

namespace Payroc\PayrocCloud;

use Payroc\PayrocCloud\PaymentInstructions\PaymentInstructionsClient;
use Payroc\PayrocCloud\RefundInstructions\RefundInstructionsClient;
use Payroc\PayrocCloud\SignatureInstructions\SignatureInstructionsClient;
use Payroc\PayrocCloud\Signatures\SignaturesClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;

class PayrocCloudClient
{
    /**
     * @var PaymentInstructionsClient $paymentInstructions
     */
    public PaymentInstructionsClient $paymentInstructions;

    /**
     * @var RefundInstructionsClient $refundInstructions
     */
    public RefundInstructionsClient $refundInstructions;

    /**
     * @var SignatureInstructionsClient $signatureInstructions
     */
    public SignatureInstructionsClient $signatureInstructions;

    /**
     * @var SignaturesClient $signatures
     */
    public SignaturesClient $signatures;

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
        $this->paymentInstructions = new PaymentInstructionsClient($this->client, $this->environment);
        $this->refundInstructions = new RefundInstructionsClient($this->client, $this->environment);
        $this->signatureInstructions = new SignatureInstructionsClient($this->client, $this->environment);
        $this->signatures = new SignaturesClient($this->client, $this->environment);
    }
}
