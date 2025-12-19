<?php

namespace Payroc\RepeatPayments\Subscriptions;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\RepeatPayments\Subscriptions\Requests\ListSubscriptionsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\Subscription;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\RepeatPayments\Subscriptions\Requests\SubscriptionRequest;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\RepeatPayments\Subscriptions\Requests\PartiallyUpdateSubscriptionsRequest;
use Payroc\RepeatPayments\Subscriptions\Requests\SubscriptionPaymentRequest;
use Payroc\Types\SubscriptionPayment;
use Payroc\Types\SubscriptionPaginatedList;
use Payroc\Core\Json\JsonSerializer;

class SubscriptionsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of subscriptions.
     *
     * Note: If you want to view the details of a specific subscription and you have its subscriptionId, use our [Retrieve subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for subscriptions for a customer, a payment plan, or frequency.
     *
     * Our gateway returns information about the following for each subscription in the list:
     *
     * -	Payment plan the subscription is linked to.
     * -	Secure token that represents cardholder’s payment details.
     * -	Current state of the subscription, including its status, next due date, and invoices.
     * -	Fees for setup and the cost of the recurring order.
     * -	Subscription length, end date, and frequency.
     *
     * For each subscription, we also return the subscriptionId, the paymentPlanId, and the secureTokenId, which you can use to perform follow-actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Subscription>
     */
    public function list(string $processingTerminalId, ListSubscriptionsRequest $request = new ListSubscriptionsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($processingTerminalId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to assign a customer to a payment plan.
     *
     * **Note:** This method is part of our Repeat Payments feature. To help you understand how this method works with our Payment plans endpoints, go to [Repeat Payments](https://docs.payroc.com/guides/integrate/repeat-payments).
     *
     * When you create a subscription you need to provide a unique subscriptionId that you use to run follow-on actions:
     *
     * - [Retrieve Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/retrieve) - View the details of the subscription.
     * - [Update Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/partially-update) - Update the details of the subscription.
     * - [Deactivate Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/deactivate) - Stop taking payments for the subscription.
     * - [Re-activate Subscription](https://docs.payroc.com/api/schema/payments/subscriptions/reactivate) - Start taking payments again for the subscription.
     * - [Pay Manual Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/pay) - Manually collect a payment for the subscription.
     *
     * The request includes the following settings:
     * - **paymentPlanId** - Unique identifier of the payment plan that the merchant wants to use. If you don't have the paymentPlanId, use our [List Payment Plans](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/list) method to search for the payment plan.
     * - **paymentMethod** - Object that contains information about the secure token, which represents the customer's card details or bank account details.
     * - **startDate** - Date that you want to start to take payments.
     *
     * You can also update the settings that the subscription inherited from the payment plan, for example, you can change the amount for each payment. If you change the settings for the subscription, it doesn't change the settings in the payment plan that it's linked to.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param SubscriptionRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Subscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(string $processingTerminalId, SubscriptionRequest $request, ?array $options = null): Subscription
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Subscription::fromJson($json);
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
     * Use this method to retrieve information about a subscription.
     *
     * To retrieve a subscription, you need its subscriptionId. You sent the subscriptionId in the request of the [Create subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List subscriptions](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/list) method to search for the subscription.
     *
     * Our gateway returns information about the following for the subscription:
     *
     * -	Payment plan the subscription is linked to.
     * -	Secure token that represents cardholder’s payment details.
     * -	Current state of the subscription, including its status, next due date, and invoices.
     * -	Fees for setup and the cost of the recurring order.
     * -	Subscription length, end date, and frequency.
     *
     * We also return the paymentPlanId and the secureTokenId, which you can use to perform follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Subscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $processingTerminalId, string $subscriptionId, ?array $options = null): Subscription
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions/{$subscriptionId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Subscription::fromJson($json);
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
     * Use this method to partially update a subscription. Structure your request to follow the [RFC 6902](https://datatracker.ietf.org/doc/html/rfc6902) standard.
     *
     * To update a subscription, you need its subscriptionId, which you sent in the request of the [Create subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List subscriptions](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/list) method to search for the payment.
     *
     * You can update all of the properties of the subscription except for the following:
     *
     * **Can't delete**
     * - recurringOrder
     * - description
     * - name
     *
     * **Can't perform any PATCH operation**
     * - currentState
     * - type
     * - frequency
     * - paymentPlan
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     * @param PartiallyUpdateSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Subscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function partiallyUpdate(string $processingTerminalId, string $subscriptionId, PartiallyUpdateSubscriptionsRequest $request, ?array $options = null): Subscription
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions/{$subscriptionId}",
                    method: HttpMethod::PATCH,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Subscription::fromJson($json);
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
     * Use this method to deactivate a subscription.
     *
     * To deactivate a subscription, you need its subscriptionId, which you sent in the request of the [Create Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List Subscriptions](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/list) method to search for the subscription.
     *
     * If your request is successful, our gateway stops taking payments from the customer.
     *
     * To reactivate the subscription, use our [Reactivate Subscription](https://docs.payroc.com/api/schema/payments/subscriptions/reactivate) method.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Subscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function deactivate(string $processingTerminalId, string $subscriptionId, ?array $options = null): Subscription
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions/{$subscriptionId}/deactivate",
                    method: HttpMethod::POST,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Subscription::fromJson($json);
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
     * Use this method to reactivate a subscription.
     *
     * To reactivate a subscription, you need its subscriptionId, which you sent in the request of the [Create Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List Subscriptions](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/list) method to search for the subscription.
     *
     * If your request is successful, our gateway restarts taking payments from the customer.
     *
     * To deactivate the subscription, use our [Deactivate Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/deactivate) method.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Subscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function reactivate(string $processingTerminalId, string $subscriptionId, ?array $options = null): Subscription
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions/{$subscriptionId}/reactivate",
                    method: HttpMethod::POST,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Subscription::fromJson($json);
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
     * Use this method to manually collect a payment linked to a subscription. You can manually collect a payment only if the merchant chose not to let our gateway automatically collect each payment.
     *
     * To manually collect a payment, you need the subscriptionId of the subscription that's linked to the payment. You sent the subscriptionId in the request of the [Create Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List Subscriptions](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/list) method to search for the subscription.
     *
     * The request includes an order object that contains information about the amount that you want to collect.
     *
     * In the response, our gateway returns information about the payment and a paymentId. You can use the paymentId in follow-on actions with the [Payments](https://docs.payroc.com/api/schema/card-payments/payments) endpoints or [Bank Transfer Payments](https://docs.payroc.com/api/schema/bank-transfer-payments/payments) endpoints.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     * @param SubscriptionPaymentRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SubscriptionPayment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function pay(string $processingTerminalId, string $subscriptionId, SubscriptionPaymentRequest $request, ?array $options = null): SubscriptionPayment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/subscriptions/{$subscriptionId}/pay",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SubscriptionPayment::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of subscriptions.
     *
     * Note: If you want to view the details of a specific subscription and you have its subscriptionId, use our [Retrieve subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for subscriptions for a customer, a payment plan, or frequency.
     *
     * Our gateway returns information about the following for each subscription in the list:
     *
     * -	Payment plan the subscription is linked to.
     * -	Secure token that represents cardholder’s payment details.
     * -	Current state of the subscription, including its status, next due date, and invoices.
     * -	Fees for setup and the cost of the recurring order.
     * -	Subscription length, end date, and frequency.
     *
     * For each subscription, we also return the subscriptionId, the paymentPlanId, and the secureTokenId, which you can use to perform follow-actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SubscriptionPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(string $processingTerminalId, ListSubscriptionsRequest $request = new ListSubscriptionsRequest(), ?array $options = null): SubscriptionPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->customerName != null) {
            $query['customerName'] = $request->customerName;
        }
        if ($request->last4 != null) {
            $query['last4'] = $request->last4;
        }
        if ($request->paymentPlan != null) {
            $query['paymentPlan'] = $request->paymentPlan;
        }
        if ($request->frequency != null) {
            $query['frequency'] = $request->frequency;
        }
        if ($request->status != null) {
            $query['status'] = $request->status;
        }
        if ($request->endDate != null) {
            $query['endDate'] = JsonSerializer::serializeDate($request->endDate);
        }
        if ($request->nextDueDate != null) {
            $query['nextDueDate'] = JsonSerializer::serializeDate($request->nextDueDate);
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
                    path: "processing-terminals/{$processingTerminalId}/subscriptions",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SubscriptionPaginatedList::fromJson($json);
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
