<?php

namespace Payroc\PaymentLinks;

use Payroc\PaymentLinks\SharingEvents\SharingEventsClient;
use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\PaymentLinks\Requests\ListPaymentLinksRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\PaymentLinkPaginatedListDataItem;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\PaymentLinks\Requests\CreatePaymentLinksRequest;
use Payroc\PaymentLinks\Types\CreatePaymentLinksResponse;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\PaymentLinks\Types\RetrievePaymentLinksResponse;
use Payroc\PaymentLinks\Requests\PartiallyUpdatePaymentLinksRequest;
use Payroc\PaymentLinks\Types\PartiallyUpdatePaymentLinksResponse;
use Payroc\PaymentLinks\Types\DeactivatePaymentLinksResponse;
use Payroc\Types\PaymentLinkPaginatedList;
use Payroc\Core\Json\JsonSerializer;

class PaymentLinksClient
{
    /**
     * @var SharingEventsClient $sharingEvents
     */
    public SharingEventsClient $sharingEvents;

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
        $this->sharingEvents = new SharingEventsClient($this->client, $this->environment);
    }

    /**
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payment links linked to a processing terminal.
     *
     * **Note:** If you want to view the details of a specific payment link and you have its paymentLinkId, use our [Retrieve Payment Link](https://docs.payroc.com/api/schema/payment-links/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for only active links or multi-use links.
     *
     * Our gateway returns the following information about each payment link in the list:
     * - **type** - Indicates whether the link can be used only once or if it can be used multiple times.
     * - **authType** - Indicates whether the transaction is a sale or a pre-authorization.
     * - **paymentMethods** - Indicates the payment method that the merchant accepts.
     * - **charge** - Indicates whether the merchant or the customer enters the amount for the transaction.
     * - **status** - Indicates if the payment link is active.
     *
     * For each payment link, we also return a paymentLinkId, which you can use for follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListPaymentLinksRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<PaymentLinkPaginatedListDataItem>
     */
    public function list(string $processingTerminalId, ListPaymentLinksRequest $request = new ListPaymentLinksRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($processingTerminalId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to create a payment link that a customer can use to make a payment for goods or services.
     *
     * The request includes the following settings:
     * - **type** - Indicates whether the link can be used only once or if it can be used multiple times.
     * - **authType** - Indicates whether the transaction is a sale or a pre-authorization.
     * - **paymentMethod** - Indicates the payment methods that the merchant accepts.
     * - **charge** - Indicates whether the merchant or the customer enters the amount for the transaction.
     *
     * If your request is successful, our gateway returns a paymentLinkId, which you can use to perform follow-on actions.
     *
     * **Note:** To share the payment link with a customer, use our [Share Payment Link](https://docs.payroc.com/api/schema/payment-links/sharing-events/share) method.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param CreatePaymentLinksRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreatePaymentLinksResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(string $processingTerminalId, CreatePaymentLinksRequest $request, ?array $options = null): CreatePaymentLinksResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-links",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreatePaymentLinksResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new PayrocException(message: $e->getMessage(), previous: $e);
            }
            throw new PayrocApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Use this method to retrieve information about a payment link.
     *
     * To retrieve a payment link, you need its paymentLinkId. Our gateway returned the paymentLinkId in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * Our gateway returns the following information about the payment link:
     * - **type** - Indicates whether the link can be used only once or if it can be used multiple times.
     * - **authType** - Indicates whether the transaction is a sale or a pre-authorization.
     * - **paymentMethods** - Indicates the payment method that the merchant accepts.
     * - **charge** - Indicates whether the merchant or the customer enters the amount for the transaction.
     * - **status** - Indicates if the payment link is active.
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievePaymentLinksResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $paymentLinkId, ?array $options = null): RetrievePaymentLinksResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payment-links/{$paymentLinkId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievePaymentLinksResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new PayrocException(message: $e->getMessage(), previous: $e);
            }
            throw new PayrocApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Use this method to partially update a payment link. Structure your request to follow the [RFC 6902](https://datatracker.ietf.org/doc/html/rfc6902) standard.
     *
     * To update a payment link, you need its paymentLinkId, which we sent you in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * You can update the following properties of a multi-use link:
     * - **expiresOn parameter** - Expiration date of the link.
     * - **customLabels object** - Label for the payment button.
     * - **credentialOnFile object** - Settings for saving the customer's payment details.
     *
     * You can update the following properties of a single-use link:
     * - **expiresOn parameter** - Expiration date of the link.
     * - **authType parameter** - Transaction type of the payment link.
     * - **amount parameter** - Total amount of the transaction.
     * - **currency parameter** - Currency of the transaction.
     * - **description parameter** - Brief description of the transaction.
     * - **customLabels object** - Label for the payment button.
     * - **credentialOnFile object** - Settings for saving the customer's payment details.
     *
     * **Note:** When a merchant updates a single-use link, we update the payment URL and HTML code in the assets object. The customer can't use the original link to make a payment.
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param PartiallyUpdatePaymentLinksRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PartiallyUpdatePaymentLinksResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function partiallyUpdate(string $paymentLinkId, PartiallyUpdatePaymentLinksRequest $request, ?array $options = null): PartiallyUpdatePaymentLinksResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payment-links/{$paymentLinkId}",
                    method: HttpMethod::PATCH,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PartiallyUpdatePaymentLinksResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new PayrocException(message: $e->getMessage(), previous: $e);
            }
            throw new PayrocApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Use this method to deactivate a payment link.
     *
     * To deactivate a payment link, you need its paymentLinkId. Our gateway returned the paymentLinkId in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * If your request is successful, our gateway deactivates the payment link. The customer can't use the link to make a payment, and you can't reactivate the payment link.
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return DeactivatePaymentLinksResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function deactivate(string $paymentLinkId, ?array $options = null): DeactivatePaymentLinksResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payment-links/{$paymentLinkId}/deactivate",
                    method: HttpMethod::POST,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return DeactivatePaymentLinksResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new PayrocException(message: $e->getMessage(), previous: $e);
            }
            throw new PayrocApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payment links linked to a processing terminal.
     *
     * **Note:** If you want to view the details of a specific payment link and you have its paymentLinkId, use our [Retrieve Payment Link](https://docs.payroc.com/api/schema/payment-links/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for only active links or multi-use links.
     *
     * Our gateway returns the following information about each payment link in the list:
     * - **type** - Indicates whether the link can be used only once or if it can be used multiple times.
     * - **authType** - Indicates whether the transaction is a sale or a pre-authorization.
     * - **paymentMethods** - Indicates the payment method that the merchant accepts.
     * - **charge** - Indicates whether the merchant or the customer enters the amount for the transaction.
     * - **status** - Indicates if the payment link is active.
     *
     * For each payment link, we also return a paymentLinkId, which you can use for follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListPaymentLinksRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentLinkPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(string $processingTerminalId, ListPaymentLinksRequest $request = new ListPaymentLinksRequest(), ?array $options = null): PaymentLinkPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->merchantReference != null) {
            $query['merchantReference'] = $request->merchantReference;
        }
        if ($request->linkType != null) {
            $query['linkType'] = $request->linkType;
        }
        if ($request->chargeType != null) {
            $query['chargeType'] = $request->chargeType;
        }
        if ($request->status != null) {
            $query['status'] = $request->status;
        }
        if ($request->recipientName != null) {
            $query['recipientName'] = $request->recipientName;
        }
        if ($request->recipientEmail != null) {
            $query['recipientEmail'] = $request->recipientEmail;
        }
        if ($request->createdOn != null) {
            $query['createdOn'] = JsonSerializer::serializeDate($request->createdOn);
        }
        if ($request->expiresOn != null) {
            $query['expiresOn'] = JsonSerializer::serializeDate($request->expiresOn);
        }
        if ($request->before != null) {
            $query['before'] = $request->before;
        }
        if ($request->after != null) {
            $query['after'] = $request->after;
        }
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-links",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentLinkPaginatedList::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new PayrocException(message: $e->getMessage(), previous: $e);
            }
            throw new PayrocApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
