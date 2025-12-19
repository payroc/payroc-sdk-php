<?php

namespace Payroc\Boarding\ProcessingAccounts;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Types\ProcessingAccount;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Types\FundingAccount;
use Payroc\Core\Json\JsonDecoder;
use Payroc\Boarding\ProcessingAccounts\Requests\ListContactsProcessingAccountsRequest;
use Payroc\Types\PaginatedContacts;
use Payroc\Types\PricingAgreementUs40;
use Payroc\Types\PricingAgreementUs50;
use Payroc\Core\Types\Union;
use Payroc\Boarding\ProcessingAccounts\Requests\ListProcessingAccountOwnersRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\Owner;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Boarding\ProcessingAccounts\Requests\CreateReminderProcessingAccountsRequest;
use Payroc\Boarding\ProcessingAccounts\Types\CreateReminderProcessingAccountsResponse;
use Payroc\Boarding\ProcessingAccounts\Requests\ListTerminalOrdersProcessingAccountsRequest;
use Payroc\Types\TerminalOrder;
use Payroc\Core\Json\JsonSerializer;
use Payroc\Boarding\ProcessingAccounts\Requests\CreateTerminalOrder;
use Payroc\Boarding\ProcessingAccounts\Requests\ListProcessingTerminalsProcessingAccountsRequest;
use Payroc\Types\ProcessingTerminal;
use Payroc\Types\PaginatedOwners;
use Payroc\Types\PaginatedProcessingTerminals;

class ProcessingAccountsClient
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
     * Use this method to retrieve information about a specific processing account.
     *
     * To retrieve a processing account, you need its processingAccountId. Our gateway returned the processingAccountId in the response of the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method or the [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don't have the processingAccountId, use our [List Merchant Platform's Processing Accounts](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list-processing-accounts) method to search for the processing account.
     *
     * Our gateway returns the following information about the processing account:
     *
     * -	Business information, including the Merchant Category Code (MCC), status of the processing account, and address of the business.
     * -	Processing information, including the merchant’s refund policies and card types that the merchant accepts.
     * -	Funding information, including funding schedules, funding fees, and details for the merchant’s funding accounts.
     * -	Pricing information, including [HATEOAS](https://docs.payroc.com/knowledge/basic-concepts/hypermedia-as-the-engine-of-application-state-hateoas) links to retrieve the pricing program for the processing account.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
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
    public function retrieve(string $processingAccountId, ?array $options = null): ProcessingAccount
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}",
                    method: HttpMethod::GET,
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
     * Retrieve a list of funding accounts associated with a processing account.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<FundingAccount>
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function listProcessingAccountFundingAccounts(string $processingAccountId, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/funding-accounts",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [FundingAccount::class]); // @phpstan-ignore-line
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
     * Use this method to return a list of contacts for a processing account.
     *
     * **Note:** If you want to view the details of a specific contact and you have their contactId, use our [Retrieve Contact](https://docs.payroc.com/api/schema/boarding/contacts/retrieve) method.
     *
     * To list contacts for a processing account, you need the processingAccountId. Our gateway returned the processingAccountId in the response of the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method or the [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * Our gateway returns the following information about each contact:
     *
     * - Name and contact method, including their phone number or mobile number.
     * - Role within the business, for example, if they are a manager.
     *
     * For each contact, we also return a contactId, which you can use to perform follow-on actions.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListContactsProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedContacts
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function listContacts(string $processingAccountId, ListContactsProcessingAccountsRequest $request = new ListContactsProcessingAccountsRequest(), ?array $options = null): PaginatedContacts
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
                    path: "processing-accounts/{$processingAccountId}/contacts",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedContacts::fromJson($json);
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
     * Use this method to retrieve the pricing agreement that we apply to a processing account.
     *
     * To retrieve the pricing agreement of a processing account, you need the processingAccountId. Our gateway returned the processingAccountId in the response to the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method and [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don't have the processingAccountId, use our [List Merchant Platform’s Processing Accounts](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list-processing-accounts) method to search for the processing account.
     *
     * Our gateway returns the following information about the pricing agreement that we apply to the processing account:
     *
     * - Base fees, including the annual fee and the fees for each chargeback and retrieval.
     * - Processor fees, including the fees that we apply for processing card and ACH payments.
     * - Gateway fees, including the setup fee and the fees for each transaction.
     * - Service fees, including the fee that we apply if the merchant has signed up to a Hardware Advantage Plan.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return (
     *    PricingAgreementUs40
     *   |PricingAgreementUs50
     * )
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function getProcessingAccountPricingAgreement(string $processingAccountId, ?array $options = null): PricingAgreementUs40|PricingAgreementUs50
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/pricing",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeUnion($json, new Union(PricingAgreementUs40::class, PricingAgreementUs50::class)); // @phpstan-ignore-line
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
     * Use this method to return a list of owners of a processing account.
     *
     * **Note:** If you want to view the details of a specific owner and you have the ownerId, go to our [Retrieve Owner](https://docs.payroc.com/api/schema/boarding/owners/retrieve) method.
     *
     * To list the owners of a processing account, you need its processingAccountId. If you don't have the processingAccountId, use our [List Merchant Platform's Processing Accounts](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list-processing-accounts) method to search for the processing account.
     *
     * Our gateway returns the following information about each owner in the list:
     *
     * - Name, date of birth, and address.
     * - Contact details, including their email address.
     * - Relationship to the business, including whether they are a control prong or authorized signatory, and their equity stake in the business.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListProcessingAccountOwnersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Owner>
     */
    public function listOwners(string $processingAccountId, ListProcessingAccountOwnersRequest $request = new ListProcessingAccountOwnersRequest(), ?array $options = null): Pager
    {
        $response = $this->_listOwners($processingAccountId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to prompt a merchant to sign their pricing agreement.
     *
     * You can create a reminder only if you requested the merchant’s signature by email when you created the processing account for the merchant.
     *
     * To create a reminder, you need the processingAccountId. Our gateway returned the processingAccountId in the response of the [Create Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create) method or [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don’t know the processingAccountId, use our [List Merchant Platform’s Processing Accounts](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list-processing-accounts) method to search for the processing account.
     *
     * When you send a successful request, we send an email to the merchant that prompts them to sign their pricing agreement.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param CreateReminderProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateReminderProcessingAccountsResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function createReminder(string $processingAccountId, CreateReminderProcessingAccountsRequest $request, ?array $options = null): CreateReminderProcessingAccountsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/reminders",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateReminderProcessingAccountsResponse::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of terminal orders associated with a processing account.
     *
     * **Note:** If you want to view the details of a specific terminal order and you have its terminalOrderId, use our [Retrieve Terminal Order](https://docs.payroc.com/api/schema/boarding/terminal-orders/retrieve) method.
     *
     * Use the query parameters to filter the list of results that we return, for example, to search for terminal orders by their status.
     *
     * To list the terminal orders for a processing account, you need its processingAccountId. If you don't have the processingAccountId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for a merchant platform and its processing accounts.
     *
     * Our gateway returns the following information for each terminal order in the list:
     *
     * - Status of the order
     * - Items in the order
     * - Training provider
     * - Shipping information
     *
     * For each terminal order, we also return its terminalOrderId, which you can use to perform follow-on actions.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListTerminalOrdersProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<TerminalOrder>
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function listTerminalOrders(string $processingAccountId, ListTerminalOrdersProcessingAccountsRequest $request = new ListTerminalOrdersProcessingAccountsRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->status != null) {
            $query['status'] = $request->status;
        }
        if ($request->fromDateTime != null) {
            $query['fromDateTime'] = JsonSerializer::serializeDateTime($request->fromDateTime);
        }
        if ($request->toDateTime != null) {
            $query['toDateTime'] = JsonSerializer::serializeDateTime($request->toDateTime);
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/terminal-orders",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [TerminalOrder::class]); // @phpstan-ignore-line
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
     * Use this method to order and configure terminals for a processing account.
     *
     * **Note**: You need the ID of the processing account before you can create an order. If you don't know the processingAccountId, go to the [Retrieve a Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/retrieve) method.
     *
     * In the request, specify the gateway settings, device settings, and application settings for the terminal.
     *
     * In the response, our gateway returns information about the terminal order including its status and terminalOrderId that you can use to [retrieve the terminal order](https://docs.payroc.com/api/schema/boarding/terminal-orders/retrieve).
     *
     * **Note**: You can subscribe to the terminalOrder.status.changed event to get notifications when we update the status of a terminal order. For more information about how to subscribe to events, go to [Events Subscriptions](https://docs.payroc.com/guides/integrate/event-subscriptions).
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param CreateTerminalOrder $request
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
    public function createTerminalOrder(string $processingAccountId, CreateTerminalOrder $request, ?array $options = null): TerminalOrder
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/terminal-orders",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
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

    /**
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of processing terminals associated with a processing account.
     *
     * **Note:** If you want to view the details of a specific processing terminal and you have its processingTerminalId, use our [Retrieve Processing Terminal](https://docs.payroc.com/api/schema/boarding/processing-terminals/retrieve) method.
     *
     * To list the terminals for a processing account, you need its processingAccountId. If you don't have the processingAccountId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for a merchant platform and its processing accounts.
     *
     * Our gateway returns the following information for each processing terminal in the list:
     *
     * - Status indicating whether the terminal is active or inactive.
     * - Configuration settings, including gateway settings and application settings.
     * - Features, receipt settings, and security settings.
     * - Devices that use the processing terminal's configuration.
     *
     * For each processing terminal, we also return its processingTerminalId, which you can use to perform follow-on actions.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListProcessingTerminalsProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<ProcessingTerminal>
     */
    public function listProcessingTerminals(string $processingAccountId, ListProcessingTerminalsProcessingAccountsRequest $request = new ListProcessingTerminalsProcessingAccountsRequest(), ?array $options = null): Pager
    {
        $response = $this->_listProcessingTerminals($processingAccountId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to return a list of owners of a processing account.
     *
     * **Note:** If you want to view the details of a specific owner and you have the ownerId, go to our [Retrieve Owner](https://docs.payroc.com/api/schema/boarding/owners/retrieve) method.
     *
     * To list the owners of a processing account, you need its processingAccountId. If you don't have the processingAccountId, use our [List Merchant Platform's Processing Accounts](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list-processing-accounts) method to search for the processing account.
     *
     * Our gateway returns the following information about each owner in the list:
     *
     * - Name, date of birth, and address.
     * - Contact details, including their email address.
     * - Relationship to the business, including whether they are a control prong or authorized signatory, and their equity stake in the business.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListProcessingAccountOwnersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedOwners
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listOwners(string $processingAccountId, ListProcessingAccountOwnersRequest $request = new ListProcessingAccountOwnersRequest(), ?array $options = null): PaginatedOwners
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
                    path: "processing-accounts/{$processingAccountId}/owners",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedOwners::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of processing terminals associated with a processing account.
     *
     * **Note:** If you want to view the details of a specific processing terminal and you have its processingTerminalId, use our [Retrieve Processing Terminal](https://docs.payroc.com/api/schema/boarding/processing-terminals/retrieve) method.
     *
     * To list the terminals for a processing account, you need its processingAccountId. If you don't have the processingAccountId, use our [List Merchant Platforms](https://docs.payroc.com/api/schema/boarding/merchant-platforms/list) method to search for a merchant platform and its processing accounts.
     *
     * Our gateway returns the following information for each processing terminal in the list:
     *
     * - Status indicating whether the terminal is active or inactive.
     * - Configuration settings, including gateway settings and application settings.
     * - Features, receipt settings, and security settings.
     * - Devices that use the processing terminal's configuration.
     *
     * For each processing terminal, we also return its processingTerminalId, which you can use to perform follow-on actions.
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param ListProcessingTerminalsProcessingAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return PaginatedProcessingTerminals
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listProcessingTerminals(string $processingAccountId, ListProcessingTerminalsProcessingAccountsRequest $request = new ListProcessingTerminalsProcessingAccountsRequest(), ?array $options = null): PaginatedProcessingTerminals
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
                    path: "processing-accounts/{$processingAccountId}/processing-terminals",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return PaginatedProcessingTerminals::fromJson($json);
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
