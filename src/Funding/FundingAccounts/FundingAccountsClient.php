<?php

namespace Payroc\Funding\FundingAccounts;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Funding\FundingAccounts\Requests\ListFundingAccountsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\FundingAccount;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Funding\FundingAccounts\Requests\UpdateFundingAccountsRequest;
use Payroc\Types\ListFundingAccounts;

class FundingAccountsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of funding accounts associated with your account.
     *
     * **Note:** If you want to view the details of a specific funding account and you have its fundingAccountId, use our [Retrieve Funding Account](https://docs.payroc.com/api/schema/funding/funding-accounts/retrieve) method.
     *
     * Our gateway returns the following information about each funding account in the list:
     * - Name of the account holder and ACH details for the account.
     * - Status of the account.
     * - Whether we send funds to the account, withdraw funds from the account, or both.
     *
     * For each funding account, we also return the fundingAccountId, which you can use to perform follow-on actions.
     *
     * @param ListFundingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<FundingAccount>
     */
    public function list(ListFundingAccountsRequest $request = new ListFundingAccountsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to retrieve information about a funding account.
     *
     * To retrieve a funding account, you need its fundingAccountId. Our gateway returned the fundingAccountId when you created the funding account.
     *
     * **Note:** If you don't have the fundingAccountId, use our [List Funding Accounts](https://docs.payroc.com/api/schema/funding/funding-accounts/list) method to search for the account.
     *
     * Our gateway returns the following information about the funding account:
     * - Name of the account holder and ACH details for the account.
     * - Status of the account.
     * - Whether we send funds to the account, withdraw funds from the account, or both.
     *
     * @param int $fundingAccountId Unique identifier of the funding account.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return FundingAccount
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(int $fundingAccountId, ?array $options = null): FundingAccount
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "funding-accounts/{$fundingAccountId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return FundingAccount::fromJson($json);
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
     * > **Important:** You can't update the details of a funding account that is associated with a processing account.
     *
     * Use this method to update the details of a funding account that is associated with a funding recipient.
     *
     * To update a funding account, you need its fundingAccountId. Our gateway returned the fundingAccountId when you created the funding account.
     *
     * **Note:** If you don’t have the fundingAccountId, use our [List Funding Accounts](https://docs.payroc.com/api/schema/funding/funding-accounts/list) method to search for the funding account.
     *
     * You can update the following details about the funding account:
     * -	Account type.
     * -	Account holder's name.
     * -	ACH information for the account.
     *
     * @param int $fundingAccountId Unique identifier of the funding account.
     * @param UpdateFundingAccountsRequest $request
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
    public function update(int $fundingAccountId, UpdateFundingAccountsRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "funding-accounts/{$fundingAccountId}",
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
     * > **Important:** You can't delete a funding account that is associated with a processing account.
     *
     * Use this method to delete a funding account that is associated with a funding recipient.
     *
     * To delete a funding account, you need its fundingAccountId. Our gateway returned the fundingAccountId when you created the funding account.
     *
     * **Note:** If you don't have the fundingAccountId, use our [List Funding Accounts](https://docs.payroc.com/api/schema/funding/funding-accounts/list) method to search for the funding account.
     *
     * @param int $fundingAccountId Unique identifier of the funding account.
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
    public function delete(int $fundingAccountId, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "funding-accounts/{$fundingAccountId}",
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of funding accounts associated with your account.
     *
     * **Note:** If you want to view the details of a specific funding account and you have its fundingAccountId, use our [Retrieve Funding Account](https://docs.payroc.com/api/schema/funding/funding-accounts/retrieve) method.
     *
     * Our gateway returns the following information about each funding account in the list:
     * - Name of the account holder and ACH details for the account.
     * - Status of the account.
     * - Whether we send funds to the account, withdraw funds from the account, or both.
     *
     * For each funding account, we also return the fundingAccountId, which you can use to perform follow-on actions.
     *
     * @param ListFundingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListFundingAccounts
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListFundingAccountsRequest $request = new ListFundingAccountsRequest(), ?array $options = null): ListFundingAccounts
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
                    path: "funding-accounts",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListFundingAccounts::fromJson($json);
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
