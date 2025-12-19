<?php

namespace Payroc\Notifications\EventSubscriptions;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Notifications\EventSubscriptions\Requests\ListEventSubscriptionsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\EventSubscription;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Notifications\EventSubscriptions\Requests\CreateEventSubscriptionsRequest;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Notifications\EventSubscriptions\Requests\UpdateEventSubscriptionsRequest;
use Payroc\Notifications\EventSubscriptions\Requests\PartiallyUpdateEventSubscriptionsRequest;
use Payroc\Types\PaginatedEventSubscriptions;

class EventSubscriptionsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of event subscriptions that are linked to your ISV account.
     *
     * **Note:** If you want to view the details of a specific event subscription and you have its id, use our [Retrieve Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for subscriptions with a specific status or an event type.
     *
     * Our gateway returns the following information about each subscription in the list:
     * - Event types that you have subscribed to.
     * - Whether you have enabled notifications for the subscription.
     * - How we contact you when an event occurs, including the endpoint that send notifications to.
     * - If there are any issues when we try to send you a notification, for example, if we can't contact your endpoint.
     *
     * For each event subscription, we also return its id, which you can use to perform follow-on actions.
     *
     * @param ListEventSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<EventSubscription>
     */
    public function list(ListEventSubscriptionsRequest $request = new ListEventSubscriptionsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to create an event subscription that we use to notify you when an event occurs, for example, when we change the status of a processing account.
     *
     * In the request, include the events that you want to subscribe to and the public endpoint that we send event notifications to. For a complete list of events that you can subscribe to, go to [Events List](https://docs.payroc.com/knowledge/events/events-list).
     *
     * In the response, our gateway returns the id of the event subscription, which you can use to perform follow-on actions.
     *
     * @param CreateEventSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return EventSubscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(CreateEventSubscriptionsRequest $request, ?array $options = null): EventSubscription
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return EventSubscription::fromJson($json);
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
     * Use this method to retrieve the details of an event subscription.
     *
     * In your request, include the subscriptionId that we sent to you when we created the event subscription.
     *
     * **Note:** If you don't know the subscriptionId of the event subscription, go to [List event subscriptions](#listEventSubscriptions).
     *
     * Unique identifier that we assigned to the event subscription.
     * **Note:** Our gateway returned the subscriptionId in the id field in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * @param int $subscriptionId
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return EventSubscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(int $subscriptionId, ?array $options = null): EventSubscription
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions/{$subscriptionId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return EventSubscription::fromJson($json);
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
     * Use this method to update the details of an event subscription.
     *
     * To update an event subscription, you need its subscriptionId. Our gateway returned the subscriptionId in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * **Note:** If you don’t have the subscriptionId, use our [List Event Subscriptions](https://docs.payroc.com/api/schema/notifications/event-subscriptions/list) method to search for the event subscription.
     *
     * You can update the following details about an event subscription:
     *
     * - Status of the event subscription.
     * - Events that you have subscribed to. For a list of events that you can subscribe to, go to [Events list](https://docs.payroc.com/knowledge/events/events-list).
     * - Information about how we contact you when an event occurs.
     *
     * Unique identifier that we assigned to the event subscription.
     * **Note:** Our gateway returned the subscriptionId in the id field in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * @param int $subscriptionId
     * @param UpdateEventSubscriptionsRequest $request
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
    public function update(int $subscriptionId, UpdateEventSubscriptionsRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions/{$subscriptionId}",
                    method: HttpMethod::PUT,
                    body: $request->body,
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
     * Use this method to delete an event subscription.
     *
     * > **Important:** After you delete an event subscription, you can’t recover it. You won't receive event notifications from the event subscription.
     *
     * To delete an event subscription, you need its subscriptionId. Our gateway returned the subscriptionId in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * If you want to stop receiving event notifications but don't want to delete the event subscription, use our [Update Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/update) method to deactivate it.
     *
     * Unique identifier that we assigned to the event subscription.
     * **Note:** Our gateway returned the subscriptionId in the id field in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * @param int $subscriptionId
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
    public function delete(int $subscriptionId, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions/{$subscriptionId}",
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
     * Use this method to partially update an event subscription. Structure your request to follow the [RFC 6902](https://datatracker.ietf.org/doc/html/rfc6902) standard.
     *
     * To update an event subscription, you need its subscriptionId. Our gateway returned the subscriptionId in the id field in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * **Note:** If you don't have the subscriptionId, use our [List Event Subscriptions](https://docs.payroc.com/api/schema/notifications/event-subscriptions/list) method to search for the subscription.
     *
     * You can update the following properties of an event subscription:
     * - **eventTypes** - Subscribe to new events or remove events that you are subscribed to.
     * - **notifications** - Information about your endpoint and who we email if we can't contact your endpoint.
     * - **enabled** - Turn on or turn off notifications for the subscription.
     *
     * Unique identifier that we assigned to the event subscription.
     * **Note:** Our gateway returned the subscriptionId in the id field in the response of the [Create Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/create) method.
     *
     * @param int $subscriptionId
     * @param PartiallyUpdateEventSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return EventSubscription
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function partiallyUpdate(int $subscriptionId, PartiallyUpdateEventSubscriptionsRequest $request, ?array $options = null): EventSubscription
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions/{$subscriptionId}",
                    method: HttpMethod::PATCH,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return EventSubscription::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of event subscriptions that are linked to your ISV account.
     *
     * **Note:** If you want to view the details of a specific event subscription and you have its id, use our [Retrieve Event Subscription](https://docs.payroc.com/api/schema/notifications/event-subscriptions/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for subscriptions with a specific status or an event type.
     *
     * Our gateway returns the following information about each subscription in the list:
     * - Event types that you have subscribed to.
     * - Whether you have enabled notifications for the subscription.
     * - How we contact you when an event occurs, including the endpoint that send notifications to.
     * - If there are any issues when we try to send you a notification, for example, if we can't contact your endpoint.
     *
     * For each event subscription, we also return its id, which you can use to perform follow-on actions.
     *
     * @param ListEventSubscriptionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedEventSubscriptions
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListEventSubscriptionsRequest $request = new ListEventSubscriptionsRequest(), ?array $options = null): PaginatedEventSubscriptions
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->status != null) {
            $query['status'] = $request->status;
        }
        if ($request->event != null) {
            $query['event'] = $request->event;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "event-subscriptions",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedEventSubscriptions::fromJson($json);
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
