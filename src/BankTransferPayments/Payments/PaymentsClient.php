<?php

namespace Payroc\BankTransferPayments\Payments;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\BankTransferPayments\Payments\Requests\ListPaymentsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\BankTransferPayment;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\BankTransferPayments\Payments\Requests\BankTransferPaymentRequest;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\BankTransferPayments\Payments\Requests\Representment;
use Payroc\Types\BankTransferPaymentPaginatedList;
use Payroc\Core\Json\JsonSerializer;

class PaymentsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payments.
     *
     * **Note:** If you want to view the details of a specific payment and you have its paymentId, use our [Retrieve Payment](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for payments for a customer, a date range, or a settlement state.
     *
     * Our gateway returns the following information about each payment in the list:
     *
     * - Order details, including the transaction amount and when it was processed.
     * - Bank account details, including the customer’s name and account number.
     * - Customer's details, including the customer’s phone number.
     * - Transaction details, including any refunds or re-presentments.
     *
     * For each transaction, we also return the paymentId and an optional secureTokenId, which you can use to perform follow-on actions.
     *
     * @param ListPaymentsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<BankTransferPayment>
     */
    public function list(ListPaymentsRequest $request, ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to run a sale with a customer's bank account details.
     *
     * In the response, our gateway returns information about the bank transfer payment and a paymentId, which you need for the following methods:
     * -	[Retrieve payment](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/retrieve) - View the details of the bank transfer payment.
     * -	[Reverse payment](https://docs.payroc.com/api/schema/bank-transfer-payments/refunds/reverse-payment) - Cancel the bank transfer payment if it's an open batch.
     * -	[Refund payment](https://docs.payroc.com/api/schema/bank-transfer-payments/refunds/refund) - Run a referenced refund to return funds to the customer's bank account.
     *
     * **Payment methods**
     *
     * Our gateway accepts the following payment methods:
     * -	Automated clearing house (ACH) details
     * -	Pre-authorized debit (PAD) details
     *
     * You can also use [secure tokens](https://docs.payroc.com/api/schema/payments/secure-tokens/overview) and [single-use tokens](https://docs.payroc.com/api/schema/tokenization/single-use-tokens/create) that you created from ACH details or PAD details.
     *
     * @param BankTransferPaymentRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return BankTransferPayment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(BankTransferPaymentRequest $request, ?array $options = null): BankTransferPayment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "bank-transfer-payments",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return BankTransferPayment::fromJson($json);
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
     * Use this method to retrieve information about a bank transfer payment.
     *
     * To retrieve a payment, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/create) method.
     *
     * Note: If you don’t have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/list) method to search for the payment.
     *
     * Our gateway returns the following information about the payment:
     *
     * -	Order details, including the transaction amount and when it was processed.
     * -	Bank account details, including the customer’s name and account number.
     * -	Customer’s details, including the customer’s phone number.
     * -	Transaction details, including any refunds or re-presentments.
     *
     * If the merchant saved the customer’s bank account details, our gateway returns a secureTokenID, which you can use to perform follow-on actions.
     *
     * @param string $paymentId Unique identifier that our gateway assigned to the payment.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return BankTransferPayment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $paymentId, ?array $options = null): BankTransferPayment
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "bank-transfer-payments/{$paymentId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return BankTransferPayment::fromJson($json);
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
     * Use this method to re-present an ACH payment.
     *
     * To re-present a payment, you need the paymentId of the return. To get the paymentId of the return, complete the following steps:
     *
     * 1.	Use our [Retrieve Payment](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/retrieve) method  to view the details of the original payment.
     * 2.	From the [returns object](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/retrieve#response.body.returns) in the response, get the paymentId of the return.
     *
     * Our gateway uses the bank account details from the original payment. If you want to update the customer's bank account details, send the new bank account details in the request.
     *
     * If your request is successful, our gateway re-presents the payment.
     *
     * @param string $paymentId Unique identifier that our gateway assigned to the payment.
     * @param Representment $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return BankTransferPayment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function represent(string $paymentId, Representment $request, ?array $options = null): BankTransferPayment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "bank-transfer-payments/{$paymentId}/represent",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return BankTransferPayment::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payments.
     *
     * **Note:** If you want to view the details of a specific payment and you have its paymentId, use our [Retrieve Payment](https://docs.payroc.com/api/schema/bank-transfer-payments/payments/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for payments for a customer, a date range, or a settlement state.
     *
     * Our gateway returns the following information about each payment in the list:
     *
     * - Order details, including the transaction amount and when it was processed.
     * - Bank account details, including the customer’s name and account number.
     * - Customer's details, including the customer’s phone number.
     * - Transaction details, including any refunds or re-presentments.
     *
     * For each transaction, we also return the paymentId and an optional secureTokenId, which you can use to perform follow-on actions.
     *
     * @param ListPaymentsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return BankTransferPaymentPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListPaymentsRequest $request, ?array $options = null): BankTransferPaymentPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['processingTerminalId'] = $request->processingTerminalId;
        if ($request->orderId != null) {
            $query['orderId'] = $request->orderId;
        }
        if ($request->nameOnAccount != null) {
            $query['nameOnAccount'] = $request->nameOnAccount;
        }
        if ($request->last4 != null) {
            $query['last4'] = $request->last4;
        }
        if ($request->type != null) {
            $query['type'] = $request->type;
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
        if ($request->paymentLinkId != null) {
            $query['paymentLinkId'] = $request->paymentLinkId;
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
                    path: "bank-transfer-payments",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return BankTransferPaymentPaginatedList::fromJson($json);
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
