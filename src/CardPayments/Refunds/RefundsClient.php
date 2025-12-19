<?php

namespace Payroc\CardPayments\Refunds;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\CardPayments\Refunds\Requests\PaymentReversal;
use Payroc\Types\Payment;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\CardPayments\Refunds\Requests\ReferencedRefund;
use Payroc\CardPayments\Refunds\Requests\ListRefundsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\RetrievedRefund;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\CardPayments\Refunds\Requests\UnreferencedRefund;
use Payroc\CardPayments\Refunds\Requests\RefundAdjustment;
use Payroc\CardPayments\Refunds\Requests\ReverseRefundRefundsRequest;
use Payroc\Types\RefundPaginatedList;
use Payroc\Core\Json\JsonSerializer;

class RefundsClient
{
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
    }

    /**
     * Use this method to cancel or to partially cancel a payment in an open batch. This is also known as voiding a payment.
     *
     * To cancel a payment, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/card-payments/payments/create) method.
     *
     * **Note:** If you don't have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/card-payments/payments/list) method to search for the payment.
     *
     * If your request is successful, our gateway removes the payment from the merchant's open batch and no funds are taken from the cardholder's account.
     *
     * @param string $paymentId Unique identifier of the payment that the merchant wants to retrieve.
     * @param PaymentReversal $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Payment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function reverse(string $paymentId, PaymentReversal $request, ?array $options = null): Payment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments/{$paymentId}/reverse",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Payment::fromJson($json);
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
     * Use this method to refund a payment that is in a closed batch.
     *
     * To refund a payment, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/card-payments/payments/create) method.
     *
     * **Note:** If you don't have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/card-payments/payments/list) method to search for the payment.
     *
     * If your refund is successful, our gateway returns the payment amount to the cardholder's account.
     *
     * **Things to consider**
     *
     * - If the merchant refunds a payment that is in an open batch, our gateway reverses the payment.
     * - Some merchants can run unreferenced refunds, which means that they don't need a paymentId to return an amount to a customer. For more information about how to run an unreferenced refund, go to [Create Refund](https://docs.payroc.com/api/schema/card-payments/refunds/create-unreferenced-refund).
     *
     * @param string $paymentId Unique identifier of the payment that the merchant wants to retrieve.
     * @param ReferencedRefund $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Payment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function createReferencedRefund(string $paymentId, ReferencedRefund $request, ?array $options = null): Payment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments/{$paymentId}/refund",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Payment::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of refunds.
     *
     * **Note:** If you want to view the details of a specific refund and you have its refundId, use our [Retrieve Refund](https://docs.payroc.com/api/schema/card-payments/refunds/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for refunds for a customer, a tender type, or a date range.
     * Our gateway returns the following information about each refund in the list:
     * - Order details, including the refund amount and when we processed the refund.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     *
     * For referenced refunds, our gateway also returns details about the payment that the refund is linked to.
     *
     * @param ListRefundsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<RetrievedRefund>
     */
    public function list(ListRefundsRequest $request = new ListRefundsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to create an unreferenced refund. An unreferenced refund is a refund that isn't linked to a payment.
     *
     * **Note:** If you have the paymentId of the payment you want to refund, use our [Refund Payment](https://docs.payroc.com/api/schema/card-payments/refunds/create-referenced-refund) method. If you use our Refund Payment method, our gateway sends the refund amount to the customer's original payment method and links the refund to the payment.
     *
     * In the request, you must provide the customer's payment details and the refund amount.
     *
     * In the response, our gateway returns information about the refund and a refundId, which you need for the following methods:
     *
     * - [Retrieve refund](https://docs.payroc.com/api/schema/card-payments/refunds/retrieve) - View the details of the refund.
     * - [Adjust refund](https://docs.payroc.com/api/schema/card-payments/refunds/adjust) - Update the details of the refund.
     * - [Reverse refund](https://docs.payroc.com/api/schema/card-payments/refunds/reverse-refund) - Cancel the refund if it's in an open batch.
     *
     * @param UnreferencedRefund $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievedRefund
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function createUnreferencedRefund(UnreferencedRefund $request, ?array $options = null): RetrievedRefund
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "refunds",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievedRefund::fromJson($json);
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
     * Use this method to retrieve information about a refund.
     *
     * To retrieve a refund, you need its refundId. Our gateway returned the refundId in the response of the [Refund Payment](https://docs.payroc.com/api/schema/card-payments/refunds/create-referenced-refund) method or the [Create Refund](https://docs.payroc.com/api/schema/card-payments/refunds/create-unreferenced-refund) method.
     *
     * **Note:** If you don't have the refundId, use our [List Refunds](https://docs.payroc.com/api/schema/card-payments/refunds/list) method to search for the refund.
     *
     * Our gateway returns the following information about the refund:
     * - Order details, including the refund amount and when we processed the refund.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     *
     * If the refund is a referenced refund, our gateway also returns details about the payment that the refund is linked to.
     *
     * @param string $refundId Unique identifier that our gateway assigned to the refund.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievedRefund
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $refundId, ?array $options = null): RetrievedRefund
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "refunds/{$refundId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievedRefund::fromJson($json);
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
     * Use this method to adjust a refund in an open batch.
     *
     * To adjust a refund, you need its refundId. Our gateway returned the refundId in the response of the [Refund Payment](https://docs.payroc.com/api/schema/card-payments/refunds/create-referenced-refund) method or the [Create Refund](https://docs.payroc.com/api/schema/card-payments/refunds/create-unreferenced-refund) method.
     *
     * **Note:** If you don’t have the refundId, use our [List Refunds](https://docs.payroc.com/api/schema/card-payments/refunds/list) method to search for the refund.
     *
     * You can adjust the following details of the refund:
     * - Customer details, including shipping address and contact information.
     * - Status of the refund.
     *
     * Our gateway returns information about the adjusted refund, including:
     * - Order details, including the refund amount and when we processed the refund.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     *
     * If the refund is a referenced refund, our gateway also returns details about the payment that the refund is linked to.
     *
     * @param string $refundId Unique identifier that our gateway assigned to the refund.
     * @param RefundAdjustment $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievedRefund
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function adjust(string $refundId, RefundAdjustment $request, ?array $options = null): RetrievedRefund
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "refunds/{$refundId}/adjust",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievedRefund::fromJson($json);
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
     * Use this method to cancel a refund in an open batch.
     *
     * To cancel a refund, you need its refundId. Our gateway returned the refundId in the response of the [Refund Payment](https://docs.payroc.com/api/schema/card-payments/refunds/create-referenced-refund) or [Create Refund](https://docs.payroc.com/api/schema/card-payments/refunds/create-unreferenced-refund) method.
     *
     * **Note:** If you don’t have the refundId, use our [List Refunds](https://docs.payroc.com/api/schema/card-payments/refunds/list) method to search for the refund.
     *
     * If your request is successful, the gateway removes the refund from the merchant’s open batch and no funds are returned to the cardholder’s account.
     *
     * @param string $refundId Unique identifier that our gateway assigned to the refund.
     * @param ReverseRefundRefundsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievedRefund
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function reverseRefund(string $refundId, ReverseRefundRefundsRequest $request, ?array $options = null): RetrievedRefund
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "refunds/{$refundId}/reverse",
                    method: HttpMethod::POST,
                    headers: $headers,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievedRefund::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of refunds.
     *
     * **Note:** If you want to view the details of a specific refund and you have its refundId, use our [Retrieve Refund](https://docs.payroc.com/api/schema/card-payments/refunds/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for refunds for a customer, a tender type, or a date range.
     * Our gateway returns the following information about each refund in the list:
     * - Order details, including the refund amount and when we processed the refund.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     *
     * For referenced refunds, our gateway also returns details about the payment that the refund is linked to.
     *
     * @param ListRefundsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RefundPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListRefundsRequest $request = new ListRefundsRequest(), ?array $options = null): RefundPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->processingTerminalId != null) {
            $query['processingTerminalId'] = $request->processingTerminalId;
        }
        if ($request->orderId != null) {
            $query['orderId'] = $request->orderId;
        }
        if ($request->operator != null) {
            $query['operator'] = $request->operator;
        }
        if ($request->cardholderName != null) {
            $query['cardholderName'] = $request->cardholderName;
        }
        if ($request->first6 != null) {
            $query['first6'] = $request->first6;
        }
        if ($request->last4 != null) {
            $query['last4'] = $request->last4;
        }
        if ($request->tender != null) {
            $query['tender'] = $request->tender;
        }
        if ($request->status != null) {
            $query['status'] = $request->status;
        }
        if ($request->dateFrom != null) {
            $query['dateFrom'] = JsonSerializer::serializeDateTime($request->dateFrom);
        }
        if ($request->dateTo != null) {
            $query['dateTo'] = JsonSerializer::serializeDateTime($request->dateTo);
        }
        if ($request->settlementState != null) {
            $query['settlementState'] = $request->settlementState;
        }
        if ($request->settlementDate != null) {
            $query['settlementDate'] = JsonSerializer::serializeDate($request->settlementDate);
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
                    path: "refunds",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RefundPaginatedList::fromJson($json);
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
