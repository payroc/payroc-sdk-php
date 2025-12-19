<?php

namespace Payroc\PaymentLinks\SharingEvents;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\PaymentLinks\SharingEvents\Requests\ListSharingEventsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\PaymentLinkEmailShareEvent;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\PaymentLinks\SharingEvents\Requests\ShareSharingEventsRequest;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Types\SharingEventPaginatedList;

class SharingEventsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of sharing events for a payment link. A sharing event occurs when a merchant shares a payment link with a customer.
     *
     * To list the sharing events for a payment link, you need its paymentLinkId. Our gateway returned the paymentLinkId in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for links sent to a specific customer.
     *
     * Our gateway returns the following information for each sharing event in the list:
     * - Customer that the merchant sent the link to.
     * - Date that the merchant sent the link.
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param ListSharingEventsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<PaymentLinkEmailShareEvent>
     */
    public function list(string $paymentLinkId, ListSharingEventsRequest $request = new ListSharingEventsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($paymentLinkId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to email a payment link to a customer.
     *
     * To email a payment link, you need its paymentLinkId. Our gateway returned the paymentLinkId in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * In the request, you must provide the recipient's name and email address.
     *
     * In the response, our gateway returns a sharingEventId, which you can use to [List Payment Link Sharing Events](https://docs.payroc.com/api/schema/payment-links/sharing-events/list).
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param ShareSharingEventsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaymentLinkEmailShareEvent
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function share(string $paymentLinkId, ShareSharingEventsRequest $request, ?array $options = null): PaymentLinkEmailShareEvent
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "payment-links/{$paymentLinkId}/sharing-events",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaymentLinkEmailShareEvent::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of sharing events for a payment link. A sharing event occurs when a merchant shares a payment link with a customer.
     *
     * To list the sharing events for a payment link, you need its paymentLinkId. Our gateway returned the paymentLinkId in the response of the [Create Payment Link](https://docs.payroc.com/api/schema/payment-links/create) method.
     *
     * **Note:** If you don't have the paymentLinkId, use our [List Payment Links](https://docs.payroc.com/api/schema/payment-links/list) method to search for the payment link.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for links sent to a specific customer.
     *
     * Our gateway returns the following information for each sharing event in the list:
     * - Customer that the merchant sent the link to.
     * - Date that the merchant sent the link.
     *
     * @param string $paymentLinkId Unique identifier that we assigned to the payment link.
     * @param ListSharingEventsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SharingEventPaginatedList
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(string $paymentLinkId, ListSharingEventsRequest $request = new ListSharingEventsRequest(), ?array $options = null): SharingEventPaginatedList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->recipientName != null) {
            $query['recipientName'] = $request->recipientName;
        }
        if ($request->recipientEmail != null) {
            $query['recipientEmail'] = $request->recipientEmail;
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
                    path: "payment-links/{$paymentLinkId}/sharing-events",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SharingEventPaginatedList::fromJson($json);
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
