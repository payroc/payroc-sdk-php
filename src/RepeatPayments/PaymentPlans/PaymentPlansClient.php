<?php

namespace Payroc\RepeatPayments\PaymentPlans;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\RepeatPayments\PaymentPlans\Requests\ListPaymentPlansRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\PaymentPlan;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\RepeatPayments\PaymentPlans\Requests\CreatePaymentPlansRequest;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\RepeatPayments\PaymentPlans\Requests\PartiallyUpdatePaymentPlansRequest;
use Payroc\Types\PaymentPlanPaginatedList;

class PaymentPlansClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payment plans for a processing terminal.
     *
     * **Note:** If you want to view the details of a specific payment plan and you have its paymentPlanId, use our [Retrieve Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/retrieve) method.
     *
     * Our gateway returns the following information about each payment plan in the list:
     *
     *   -	Name, length, and currency of the plan
     *   -	How often our gateway collects each payment
     *   -	How much our gateway collects for each payment
     *   -	What happens if the merchant updates or deletes the plan
     *
     * For each payment plan, we return the paymentPlanId, which you can use to perform follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListPaymentPlansRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<PaymentPlan>
     */
    public function list(string $processingTerminalId, ListPaymentPlansRequest $request = new ListPaymentPlansRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($processingTerminalId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to create a payment schedule that you can assign customers to.
     *
     * **Note:** This method is part of our Repeat Payments feature. To help you understand how this method works with our Subscriptions endpoints, go to [Repeat Payments](https://docs.payroc.com/guides/integrate/repeat-payments).
     *
     * When you create a payment plan you need to provide a unique paymentPlanId that you use to run follow-on actions:
     *
     * -	[Retrieve Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/retrieve)  - View the details of the payment plan.
     * -	[Update Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/partially-update)  - Update the details of the payment plan.
     * -	[Delete Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/delete)  - Delete the payment plan.
     * -	[Create Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/create)  - Subscribe a customer to the payment plan.
     *
     * The request includes the following settings:
     *
     * -	**type** - Indicates if our gateway or the merchant collects payments. If the merchant manually collects payments, integrate with the [Pay Manual Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/pay) method.
     * -	**recurringOrder** - Amount of each payment if the gateway automatically collect payments.
     * -	**setupOrder** - Setup fee that our gateway immediately collects from the customer's payment method.
     * -	**onUpdate and onDelete** - Indicates what happens to associated subscriptions if the merchant updates or deletes the payment plan.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param CreatePaymentPlansRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentPlan
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(string $processingTerminalId, CreatePaymentPlansRequest $request, ?array $options = null): PaymentPlan
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-plans",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentPlan::fromJson($json);
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
     * Use this method to retrieve information about a payment plan.
     *
     * To retrieve a payment plan, you need its paymentPlanId. Our gateway returned the paymentPlanId in the response of the [Create Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/create) method.
     *
     * **Note:** If you don't have the paymentPlanId, use our [List Payment Plans](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/list) method to search for the payment plan.
     *
     * Our gateway returns the following information about the payment plan:
     *
     *   -	Name, length, and currency of the plan
     *   -	How often our gateway collects each payment
     *   -	How much our gateway collects for each payment
     *   -	What happens if the merchant updates or deletes the plan
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $paymentPlanId Unique identifier that the merchant assigned to the payment plan.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentPlan
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $processingTerminalId, string $paymentPlanId, ?array $options = null): PaymentPlan
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-plans/{$paymentPlanId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentPlan::fromJson($json);
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
     * Use this method to delete a payment plan.
     *
     * > **Important:** When you delete a payment plan, you can’t recover it. You also won’t be able to add subscriptions to the payment plan.
     *
     * To delete a payment plan, you need its paymentPlanId, which you sent in the request of the [Create Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/create) method.
     *
     * **Note:** If you don't have the paymentPlanId, use our [List Payment Plans](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/list) method to search for the payment plan.
     *
     * The value you sent for the onDelete parameter when you created the payment plan indicates what happens to associated subscriptions when you delete the plan:
     *
     *   -	`complete` - Our gateway stops taking payments for the subscriptions associated with the payment plan.
     *   -	`continue` - Our gateway continues to take payments for the subscriptions associated with the payment plan. To stop a subscription for a cancelled payment plan, go to the [Deactivate Subscription](https://docs.payroc.com/api/schema/repeat-payments/subscriptions/deactivate) method.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $paymentPlanId Unique identifier that the merchant assigned to the payment plan.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function delete(string $processingTerminalId, string $paymentPlanId, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-plans/{$paymentPlanId}",
                    method: HttpMethod::DELETE,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                return;
            }
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
     * Use this method to partially update a payment plan. Structure your request to follow the [RFC 6902](https://datatracker.ietf.org/doc/html/rfc6902) standard.
     *
     * To update a payment plan, you need its paymentPlanId, which you sent in the request of the [Create Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/create) method.
     *
     * **Note:** If you don't have the paymentPlanId, use our [List Payment Plans](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/list) method to search for the payment plan.
     *
     * You can update all of the properties of the payment plan except for the paymentPlanId.
     *
     * The value you sent for the onUpdate parameter when you created the payment plan indicates what happens to the associated subscriptions when you update the plan:
     * - `update` - Our gateway updates the subscriptions associated with the payment plan.
     * - `continue` - Our  gateway doesn't update the subscriptions associated with the payment plan.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $paymentPlanId Unique identifier that the merchant assigned to the payment plan.
     * @param PartiallyUpdatePaymentPlansRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentPlan
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function partiallyUpdate(string $processingTerminalId, string $paymentPlanId, PartiallyUpdatePaymentPlansRequest $request, ?array $options = null): PaymentPlan
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/payment-plans/{$paymentPlanId}",
                    method: HttpMethod::PATCH,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentPlan::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of payment plans for a processing terminal.
     *
     * **Note:** If you want to view the details of a specific payment plan and you have its paymentPlanId, use our [Retrieve Payment Plan](https://docs.payroc.com/api/schema/repeat-payments/payment-plans/retrieve) method.
     *
     * Our gateway returns the following information about each payment plan in the list:
     *
     *   -	Name, length, and currency of the plan
     *   -	How often our gateway collects each payment
     *   -	How much our gateway collects for each payment
     *   -	What happens if the merchant updates or deletes the plan
     *
     * For each payment plan, we return the paymentPlanId, which you can use to perform follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListPaymentPlansRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentPlanPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(string $processingTerminalId, ListPaymentPlansRequest $request = new ListPaymentPlansRequest(), ?array $options = null): PaymentPlanPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
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
                    path: "processing-terminals/{$processingTerminalId}/payment-plans",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentPlanPaginatedList::fromJson($json);
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
