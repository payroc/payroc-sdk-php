<?php

namespace Payroc\Boarding\MerchantPlatforms;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Boarding\MerchantPlatforms\Requests\ListMerchantPlatformsRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\MerchantPlatform;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Boarding\MerchantPlatforms\Requests\CreateMerchantAccount;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Boarding\MerchantPlatforms\Requests\ListBoardingMerchantPlatformProcessingAccountsRequest;
use Payroc\Types\ProcessingAccount;
use Payroc\Boarding\MerchantPlatforms\Requests\CreateProcessingAccountMerchantPlatformsRequest;
use Payroc\Types\PaginatedMerchants;
use Payroc\Types\PaginatedProcessingAccounts;

class MerchantPlatformsClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of merchant platforms that are linked to your ISV account.
     *
     * **Note**: If you want to view the details of a specific merchant platform and you have its merchantPlatformId, use our [Retrieve Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/retrieve) method.
     *
     * Our gateway returns the following information about each merchant platform in the list:
     * - Legal information, including its legal name and address.
     * - Contact information, including the email address for the business.
     * - Processing  account information, including the processingAccountId and status of each processing account that's linked to the merchant platform.
     *
     * For each merchant platform, we also return its merchantPlatformId and its linked processingAccountIds, which you can use to perform follow-on actions.
     *
     * @param ListMerchantPlatformsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<MerchantPlatform>
     */
    public function list(ListMerchantPlatformsRequest $request = new ListMerchantPlatformsRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to board a merchant with Payroc.
     *
     * **Note**: This method is part of our Boarding solution. To help you understand how this method works with other Boarding methods, go to [Board a Merchant](https://docs.payroc.com/guides/integrate/boarding).
     *
     * In the request, include the following information:
     * - Legal information, including its legal name and address.
     * - Contact information, including the email address for the business.
     * - Processing account information, including the pricing model, owners, and contacts for the processing account.
     *
     * When you send a successful request, we review the merchant's information. After we complete our review and approve the merchant, we assign:
     * - **merchantPlatformId** - Unique identifier for the merchant platform.
     * - **processingAccountId** - Unique identifier for each processing account linked to the merchant platform.
     *
     * You need to keep these to perform follow-on actions, for example, you need the processingAccountId to [order terminals](https://docs.payroc.com/api/schema/boarding/processing-accounts/create-terminal-order) for the processing account.
     *
     * @param CreateMerchantAccount $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return MerchantPlatform
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(CreateMerchantAccount $request, ?array $options = null): MerchantPlatform
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "merchant-platforms",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return MerchantPlatform::fromJson($json);
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
     * Use this method to retrieve information about a merchant platform.
     *
     * To retrieve a merchant platform, you need its merchantPlatformId. Our gateway returned the merchantPlatformId in the response of the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method.
     *
     * **Note:** If you don't have the merchantPlatformId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for the merchant platform.
     *
     * Our gateway returns the following information about the merchant platform:
     * -	Legal information, including its legal name and address.
     * -	Contact information, including the email address for the business.
     * -	Processing account information, including the processingAccountId and status of each processing account that's linked to the merchant platform.
     *
     * @param string $merchantPlatformId Unique identifier of the merchant platform that we sent to you when you created the merchant platform.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return MerchantPlatform
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $merchantPlatformId, ?array $options = null): MerchantPlatform
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "merchant-platforms/{$merchantPlatformId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return MerchantPlatform::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of processing accounts linked to a merchant platform.
     *
     * **Note**: If you want to view the details of a specific processing account and you have its processingAccountId, use our [Retrieve Processing Account](https://docs.payroc.com/api/schema/boarding/processing-accounts/retrieve) method.
     *
     * Use the query parameters to filter the list of results that we return, for example, to search for only closed processing accounts.
     *
     * To list the processing accounts for a merchant platform, you need its merchantPlatformId. If you don't have the merchantPlatformId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for the merchant platform.
     *
     * Our gateway returns the following information about eahc processing account in the list:
     * - Business details, including its status, time zone, and address.
     * - Owners' details, including their contact details.
     * - Funding, pricing, and processing information, including its pricing model and funding accounts.
     *
     * For each processing account, we also return its processingAccountId, which you can use to perform follow-on actions.
     *
     * @param string $merchantPlatformId Unique identifier of the merchant platform that we sent to you when you created the merchant platform.
     * @param ListBoardingMerchantPlatformProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<ProcessingAccount>
     */
    public function listProcessingAccounts(string $merchantPlatformId, ListBoardingMerchantPlatformProcessingAccountsRequest $request = new ListBoardingMerchantPlatformProcessingAccountsRequest(), ?array $options = null): Pager
    {
        $response = $this->_listProcessingAccounts($merchantPlatformId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to add an additional processing account to a merchant platform.
     *
     * To add a processing account to a merchant platform, you need the merchantPlatformId. Our gateway returned the merchantPlatformId in the response of the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method.
     *
     * **Note**: If you don't have the merchantPlatformId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for the merchant platform.
     *
     * In the request, include the following information:
     * - Business details, including its business type, time zone, and address.
     * - Owners' details, including their contact details.
     * - Funding, pricing, and processing information, including its pricing model and funding accounts.
     *
     * When you send a successful request, we review the information about the processing account. After we complete our review and approve the processing account, we assign a processingAccountId, which you need to perform follow-on actions.
     *
     * **Note**: You can subscribe to our processingAccount.status.changed event to get notifications when we update the status of a processing account. For more information about how to subscribe to events, go to [Events List](https://docs.payroc.com/knowledge/events/events-list).
     *
     * @param string $merchantPlatformId Unique identifier of the merchant platform that we sent to you when you created the merchant platform.
     * @param CreateProcessingAccountMerchantPlatformsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ProcessingAccount
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function createProcessingAccount(string $merchantPlatformId, CreateProcessingAccountMerchantPlatformsRequest $request, ?array $options = null): ProcessingAccount
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "merchant-platforms/{$merchantPlatformId}/processing-accounts",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ProcessingAccount::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of merchant platforms that are linked to your ISV account.
     *
     * **Note**: If you want to view the details of a specific merchant platform and you have its merchantPlatformId, use our [Retrieve Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/retrieve) method.
     *
     * Our gateway returns the following information about each merchant platform in the list:
     * - Legal information, including its legal name and address.
     * - Contact information, including the email address for the business.
     * - Processing  account information, including the processingAccountId and status of each processing account that's linked to the merchant platform.
     *
     * For each merchant platform, we also return its merchantPlatformId and its linked processingAccountIds, which you can use to perform follow-on actions.
     *
     * @param ListMerchantPlatformsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedMerchants
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(ListMerchantPlatformsRequest $request = new ListMerchantPlatformsRequest(), ?array $options = null): PaginatedMerchants
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
                    path: "merchant-platforms",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedMerchants::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of processing accounts linked to a merchant platform.
     *
     * **Note**: If you want to view the details of a specific processing account and you have its processingAccountId, use our [Retrieve Processing Account](https://docs.payroc.com/api/schema/boarding/processing-accounts/retrieve) method.
     *
     * Use the query parameters to filter the list of results that we return, for example, to search for only closed processing accounts.
     *
     * To list the processing accounts for a merchant platform, you need its merchantPlatformId. If you don't have the merchantPlatformId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for the merchant platform.
     *
     * Our gateway returns the following information about eahc processing account in the list:
     * - Business details, including its status, time zone, and address.
     * - Owners' details, including their contact details.
     * - Funding, pricing, and processing information, including its pricing model and funding accounts.
     *
     * For each processing account, we also return its processingAccountId, which you can use to perform follow-on actions.
     *
     * @param string $merchantPlatformId Unique identifier of the merchant platform that we sent to you when you created the merchant platform.
     * @param ListBoardingMerchantPlatformProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedProcessingAccounts
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listProcessingAccounts(string $merchantPlatformId, ListBoardingMerchantPlatformProcessingAccountsRequest $request = new ListBoardingMerchantPlatformProcessingAccountsRequest(), ?array $options = null): PaginatedProcessingAccounts
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
        if ($request->includeClosed != null) {
            $query['includeClosed'] = $request->includeClosed;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "merchant-platforms/{$merchantPlatformId}/processing-accounts",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedProcessingAccounts::fromJson($json);
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
