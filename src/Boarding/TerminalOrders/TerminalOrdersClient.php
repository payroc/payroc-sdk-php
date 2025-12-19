<?php

namespace Payroc\Boarding\TerminalOrders;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Types\TerminalOrder;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;

class TerminalOrdersClient
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
     * Use this method to retrieve information about a terminal order.
     *
     * To retrieve a terminal order, you need it's terminalOrderId. Our gateway returned the terminalOrderId in the response of the [Create Terminal Order](https://docs.payroc.com/api/schema/boarding/processing-accounts/create-terminal-order) method.
     *
     * **Note**: If you don't have the terminalOrderId, use our [List Terminal Orders](https://docs.payroc.com/api/schema/boarding/processing-accounts/list-terminal-orders) method to search for the terminal order.
     *
     * Our gateway returns the following information about the terminal order:
     * - Status of the order
     * - Items in the order
     * - Training provider
     * - Shipping information
     *
     * **Note**: You can subscribe to our terminalOrder.status.changed event to get notifications when we update the status of a terminal order. For more information about how to subscribe to events, go to [Events Subscriptions](https://docs.payroc.com/guides/integrate/event-subscriptions).
     *
     * @param string $terminalOrderId Unique identifier of the terminal order.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return TerminalOrder
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $terminalOrderId, ?array $options = null): TerminalOrder
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "terminal-orders/{$terminalOrderId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return TerminalOrder::fromJson($json);
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
