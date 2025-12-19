<?php

namespace Payroc;

use Payroc\PaymentLinks\PaymentLinksClient;
use Payroc\HostedFields\HostedFieldsClient;
use Payroc\ApplePaySessions\ApplePaySessionsClient;
use Payroc\Auth\AuthClient;
use Payroc\Funding\FundingClient;
use Payroc\BankTransferPayments\BankTransferPaymentsClient;
use Payroc\Boarding\BoardingClient;
use Payroc\CardPayments\CardPaymentsClient;
use Payroc\Notifications\NotificationsClient;
use Payroc\PaymentFeatures\PaymentFeaturesClient;
use Payroc\PayrocCloud\PayrocCloudClient;
use Payroc\RepeatPayments\RepeatPaymentsClient;
use Payroc\Reporting\ReportingClient;
use Payroc\Tokenization\TokenizationClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Core\InferredAuthProvider;

class PayrocClient
{
    /**
     * @var PaymentLinksClient $paymentLinks
     */
    public PaymentLinksClient $paymentLinks;

    /**
     * @var HostedFieldsClient $hostedFields
     */
    public HostedFieldsClient $hostedFields;

    /**
     * @var ApplePaySessionsClient $applePaySessions
     */
    public ApplePaySessionsClient $applePaySessions;

    /**
     * @var AuthClient $auth
     */
    public AuthClient $auth;

    /**
     * @var FundingClient $funding
     */
    public FundingClient $funding;

    /**
     * @var BankTransferPaymentsClient $bankTransferPayments
     */
    public BankTransferPaymentsClient $bankTransferPayments;

    /**
     * @var BoardingClient $boarding
     */
    public BoardingClient $boarding;

    /**
     * @var CardPaymentsClient $cardPayments
     */
    public CardPaymentsClient $cardPayments;

    /**
     * @var NotificationsClient $notifications
     */
    public NotificationsClient $notifications;

    /**
     * @var PaymentFeaturesClient $paymentFeatures
     */
    public PaymentFeaturesClient $paymentFeatures;

    /**
     * @var PayrocCloudClient $payrocCloud
     */
    public PayrocCloudClient $payrocCloud;

    /**
     * @var RepeatPaymentsClient $repeatPayments
     */
    public RepeatPaymentsClient $repeatPayments;

    /**
     * @var ReportingClient $reporting
     */
    public ReportingClient $reporting;

    /**
     * @var TokenizationClient $tokenization
     */
    public TokenizationClient $tokenization;

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
     * @var InferredAuthProvider $inferredAuthProvider
     */
    private InferredAuthProvider $inferredAuthProvider;

    /**
     * @param ?string $apiKey The API key of the application
     * @param ?Environments $environment The environment to use for API requests.
     * @param ?array{
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        ?string $apiKey = null,
        ?Environments $environment = null,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'Payroc',
            'X-Fern-SDK-Version' => '0.0.1438',
            'User-Agent' => 'payroc/payroc/0.0.1438',
        ];
        if ($apiKey != null) {
            $defaultHeaders['x-api-key'] = $apiKey;
        }

        $this->options = $options ?? [];
        $environment ??= Environments::Production();
        $this->environment = $environment;

        $authRawClient = new RawClient(['headers' => []]);
        $authClient = new AuthClient($authRawClient, $environment);
        $inferredAuthOptions = [
            'apiKey' => $apiKey ?? '',
        ];
        $this->inferredAuthProvider = new InferredAuthProvider($authClient, $inferredAuthOptions);

        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->options['getAuthHeaders'] = fn () =>
            $this->inferredAuthProvider->getAuthHeaders();

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->paymentLinks = new PaymentLinksClient($this->client, $this->environment);
        $this->hostedFields = new HostedFieldsClient($this->client, $this->environment);
        $this->applePaySessions = new ApplePaySessionsClient($this->client, $this->environment);
        $this->auth = new AuthClient($this->client, $this->environment);
        $this->funding = new FundingClient($this->client, $this->environment);
        $this->bankTransferPayments = new BankTransferPaymentsClient($this->client, $this->environment);
        $this->boarding = new BoardingClient($this->client, $this->environment);
        $this->cardPayments = new CardPaymentsClient($this->client, $this->environment);
        $this->notifications = new NotificationsClient($this->client, $this->environment);
        $this->paymentFeatures = new PaymentFeaturesClient($this->client, $this->environment);
        $this->payrocCloud = new PayrocCloudClient($this->client, $this->environment);
        $this->repeatPayments = new RepeatPaymentsClient($this->client, $this->environment);
        $this->reporting = new ReportingClient($this->client, $this->environment);
        $this->tokenization = new TokenizationClient($this->client, $this->environment);
    }
}
