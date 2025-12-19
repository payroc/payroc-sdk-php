<?php

namespace Payroc\Funding\FundingActivity;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Funding\FundingActivity\Requests\RetrieveBalanceFundingActivityRequest;
use Payroc\Funding\FundingActivity\Types\RetrieveBalanceFundingActivityResponse;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Funding\FundingActivity\Requests\ListFundingActivityRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\ActivityRecord;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Funding\FundingActivity\Types\ListFundingActivityResponse;
use Payroc\Core\Json\JsonSerializer;

class FundingActivityClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of funding balances available for each merchant linked to your account.
     *
     * Use query parameters to filter the list of results we return, for example, to search for the funding balance for a specific merchant.
     *
     * Our gateway returns the following information about each merchant in the list:
     * - Total funds for the merchant.
     * - Available funds that you can use for funding instructions.
     * - Pending funds that we have not yet sent to funding accounts.
     *
     * @param RetrieveBalanceFundingActivityRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RetrieveBalanceFundingActivityResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieveBalance(RetrieveBalanceFundingActivityRequest $request = new RetrieveBalanceFundingActivityRequest(), ?array $options = null): RetrieveBalanceFundingActivityResponse
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
        if ($request->merchantId != null) {
            $query['merchantId'] = $request->merchantId;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "funding-balance",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RetrieveBalanceFundingActivityResponse::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of activity associated with your merchants' funding balances within a specific date range.
     *
     * Use query parameters to filter the list of results we return, for example, to view the activity for a specific merchant's funding balance.
     *
     * Our gateway returns the following information about each activity in the list:
     * - Name of the merchant who owns the funding balance.
     * -	Amount of funds added or removed from the funding balance.
     * -	Funding account that received funds from the funding balance.
     *
     * @param ListFundingActivityRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<ActivityRecord>
     */
    public function list(ListFundingActivityRequest $request, ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of activity associated with your merchants' funding balances within a specific date range.
     *
     * Use query parameters to filter the list of results we return, for example, to view the activity for a specific merchant's funding balance.
     *
     * Our gateway returns the following information about each activity in the list:
     * - Name of the merchant who owns the funding balance.
     * -	Amount of funds added or removed from the funding balance.
     * -	Funding account that received funds from the funding balance.
     *
     * @param ListFundingActivityRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListFundingActivityResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListFundingActivityRequest $request, ?array $options = null): ListFundingActivityResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['dateFrom'] = JsonSerializer::serializeDate($request->dateFrom);
        $query['dateTo'] = JsonSerializer::serializeDate($request->dateTo);
        if ($request->before != null) {
            $query['before'] = $request->before;
        }
        if ($request->after != null) {
            $query['after'] = $request->after;
        }
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        if ($request->merchantId != null) {
            $query['merchantId'] = $request->merchantId;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "funding-activity",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListFundingActivityResponse::fromJson($json);
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
