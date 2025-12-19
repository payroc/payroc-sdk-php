<?php

namespace Payroc\CardPayments\Payments;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\CardPayments\Payments\Requests\ListPaymentsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\RetrievedPayment;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\CardPayments\Payments\Requests\PaymentRequest;
use Payroc\Types\Payment;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\CardPayments\Payments\Requests\PaymentAdjustment;
use Payroc\CardPayments\Payments\Requests\PaymentCapture;
use Payroc\Types\PaymentPaginatedListForRead;
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
     * **Note:** If you want to view the details of a specific payment and you have its paymentId, use our [Retrieve Payment](https://docs.payroc.com/api/schema/card-payments/payments/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for payments for a customer, a tip mode, or a date range.
     *
     * Our gateway returns the following information about each payment in the list:
     *
     * - Order details, including the transaction amount and when it was processed.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     * - Payment details, including the payment type, status, and response.
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
     * @return Pager<RetrievedPayment>
     */
    public function list(ListPaymentsRequest $request = new ListPaymentsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to run a sale or a pre-authorization with a customer's payment card.
     *
     * In the response, our gateway returns information about the card payment and a paymentId, which you need for the following methods:
     *
     * -	[Retrieve payment](https://docs.payroc.com/api/schema/card-payments/payments/retrieve) - View the details of the card payment.
     * -	[Adjust payment](https://docs.payroc.com/api/schema/card-payments/payments/adjust) - Update the details of the card payment.
     * -	[Capture payment](https://docs.payroc.com/api/schema/card-payments/payments/capture)  - Capture the pre-authorization.
     * -	[Reverse payment](https://docs.payroc.com/api/schema/card-payments/refunds/reverse)  - Cancel the card payment if it's in an open batch.
     * -	[Refund payment](https://docs.payroc.com/api/schema/card-payments/refunds/create-referenced-refund)  - Run a referenced refund to return funds to the payment card.
     *
     * **Payment methods**
     *
     * - **Cards** - Credit, debit, and EBT
     * - **Digital wallets** - [Apple Pay®](https://docs.payroc.com/guides/integrate/apple-pay) and [Google Pay®](https://docs.payroc.com/guides/integrate/google-pay)
     * - **Tokens** - Secure tokens and single-use tokens
     *
     * **Features**
     *
     * Our Create Payment method also supports the following features:
     *
     * - [Repeat payments](https://docs.payroc.com/guides/integrate/repeat-payments/use-your-own-software) - Run multiple payments as part of a payment schedule that you manage with your own software.
     * - **Offline sales** - Run a sale or a pre-authorization if the terminal loses its connection to our gateway.
     * - [Tokenization](https://docs.payroc.com/guides/integrate/save-payment-details) - Save card details to use in future transactions.
     * - [3-D Secure](https://docs.payroc.com/guides/integrate/3-d-secure) - Verify the identity of the cardholder.
     * - [Custom fields](https://docs.payroc.com/guides/integrate/add-custom-fields) - Add your own data to a payment.
     * - **Tips** - Add tips to the card payment.
     * - **Taxes** - Add local taxes to the card payment.
     * - **Surcharging** - Add a surcharge to the card payment.
     * - **Dual pricing** - Offer different prices based on payment method, for example, if you use our RewardPay Choice pricing program.
     *
     * @param PaymentRequest $request
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
    public function create(PaymentRequest $request, ?array $options = null): Payment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments",
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
     * Use this method to retrieve information about a card payment.
     *
     * To retrieve a payment, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/card-payments/payments/create) method.
     *
     * **Note:** If you don't have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/card-payments/payments/list) method to search for the payment.
     *
     * Our gateway returns the following information about the payment:
     *
     * - Order details, including the transaction amount and when it was processed.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     * - Payment details, including the payment type, status, and response.
     *
     * If the merchant saved the customer's card details, our gateway returns a secureTokenID, which you can use to perform follow-on actions.
     *
     * @param string $paymentId Unique identifier of the payment that the merchant wants to retrieve.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrievedPayment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $paymentId, ?array $options = null): RetrievedPayment
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments/{$paymentId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrievedPayment::fromJson($json);
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
     * Use this method to adjust a payment in an open batch.
     *
     * To adjust a payment, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/card-payments/payments/create) method.
     *
     * **Note:** If you don't have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/card-payments/payments/list) method to search for the payment.
     *
     * You can adjust the following details of the payment:
     * - Sale amount and tip amount
     * - Payment status
     * - Cardholder shipping address and contact information
     * - Cardholder signature data
     *
     * Our gateway returns information about the adjusted payment, including information about the payment card and the cardholder.
     *
     * @param string $paymentId Unique identifier of the payment that the merchant wants to retrieve.
     * @param PaymentAdjustment $request
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
    public function adjust(string $paymentId, PaymentAdjustment $request, ?array $options = null): Payment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments/{$paymentId}/adjust",
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
     * Use this method to capture a pre-authorization.
     *
     * To capture a pre-authorization, you need its paymentId. Our gateway returned the paymentId in the response of the [Create Payment](https://docs.payroc.com/api/schema/card-payments/payments/create) method.
     *
     * **Note:** If you don't have the paymentId, use our [List Payments](https://docs.payroc.com/api/schema/card-payments/payments/list) method to search for the payment.
     *
     * Depending on the amount you want to capture, complete the following:
     * -	**Capture the full amount of the pre-authorization** - Don't send a value for the amount parameter in your request.
     * -	**Capture less than the amount of the pre-authorization** - Send a value for the amount parameter in your request.
     * -	**Capture more than the amount of the pre-authorization** - Adjust the pre-authorization before you capture it. For more information about adjusting a pre-authorization, go to [Adjust Payment](https://docs.payroc.com/api/schema/card-payments/payments/adjust).
     *
     * If your request is successful, our gateway takes the amount from the payment card.
     *
     * **Note:** For more information about pre-authorizations and captures, go to [Run a pre-authorization](https://docs.payroc.com/guides/integrate/run-a-pre-authorization).
     *
     * @param string $paymentId Unique identifier of the payment that the merchant wants to retrieve.
     * @param PaymentCapture $request
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
    public function capture(string $paymentId, PaymentCapture $request, ?array $options = null): Payment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payments/{$paymentId}/capture",
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payments.
     *
     * **Note:** If you want to view the details of a specific payment and you have its paymentId, use our [Retrieve Payment](https://docs.payroc.com/api/schema/card-payments/payments/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for payments for a customer, a tip mode, or a date range.
     *
     * Our gateway returns the following information about each payment in the list:
     *
     * - Order details, including the transaction amount and when it was processed.
     * - Payment card details, including the masked card number, expiry date, and payment method.
     * - Cardholder details, including their contact information and shipping address.
     * - Payment details, including the payment type, status, and response.
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
     * @return PaymentPaginatedListForRead
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListPaymentsRequest $request = new ListPaymentsRequest(), ?array $options = null): PaymentPaginatedListForRead
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
        if ($request->tipMode != null) {
            $query['tipMode'] = $request->tipMode;
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
                    path: "payments",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentPaginatedListForRead::fromJson($json);
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
