<?php

namespace Payroc\Reporting\Settlement;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementBatchesRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\Batch;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementTransactionsRequest;
use Payroc\Types\Transaction;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAuthorizationsRequest;
use Payroc\Types\Authorization;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementDisputesRequest;
use Payroc\Types\Dispute;
use Payroc\Types\DisputeStatus;
use Payroc\Core\Json\JsonDecoder;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAchDepositsRequest;
use Payroc\Types\AchDeposit;
use Payroc\Reporting\Settlement\Requests\ListReportingSettlementAchDepositFeesRequest;
use Payroc\Types\AchDepositFee;
use Payroc\Reporting\Settlement\Types\ListBatchesSettlementResponse;
use Payroc\Core\Json\JsonSerializer;
use Payroc\Reporting\Settlement\Types\ListTransactionsSettlementResponse;
use Payroc\Reporting\Settlement\Types\ListAuthorizationsSettlementResponse;
use Payroc\Reporting\Settlement\Types\ListDisputesSettlementResponse;
use Payroc\Reporting\Settlement\Types\ListAchDepositsSettlementResponse;
use Payroc\Reporting\Settlement\Types\ListAchDepositFeesSettlementResponse;

class SettlementClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of batches that your merchants submitted to the processor on a specific date.
     *
     * **Note:** If you want to view the details of a specific batch and you have its batchId, use our [Retrieve Batch](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-batch) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for batches that were submitted by a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each batch in the list:
     * -	Transaction information, including the number of transactions and total value of sales.
     * -	Merchant information, including the merchant ID (MID) and the processing account that the batch is associated with.
     *
     * @param ListReportingSettlementBatchesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Batch>
     */
    public function listBatches(ListReportingSettlementBatchesRequest $request, ?array $options = null): Pager
    {
        $response = $this->_listBatches($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to retrieve information about a batch.
     *
     * **Note:** To retrieve a batch, you need its batchId. If you don't have the batchId, use our [List Batches](https://docs.payroc.com/api/schema/reporting/settlement/list-batches) method to search for the batch.
     *
     * Our gateway returns the following information about the batch:
     *
     * -	Transaction information, including the number of transactions and total value of sales.
     * -	Merchant information, including the merchant ID (MID) and the processing account that the batch is associated with.
     *
     * @param int $batchId Unique identifier that we assigned to the batch.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Batch
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieveBatch(int $batchId, ?array $options = null): Batch
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "batches/{$batchId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Batch::fromJson($json);
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
     * Use this method to return a paginated list of your merchants’ transactions.
     *
     * **Note:** If you want to view the details of a specific transaction and you have its transactionId, use our [Retrieve Transaction](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-transaction) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for transactions for a specific merchant.
     *
     * > **Important:** You must provide a value for either the date query parameter or the batchId query parameter.
     *
     * Our gateway returns the following information about each transaction in the list:
     *
     * -	Merchant and processing account that ran the transaction.
     * -	Transaction type, date, amount, and the payment method that the customer used.
     * -	Batch that contains the transaction, and authorization details for the transaction.
     * -	Processor that settled the transaction and the ACH deposit containing the transaction.
     *
     * @param ListReportingSettlementTransactionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Transaction>
     */
    public function listTransactions(ListReportingSettlementTransactionsRequest $request = new ListReportingSettlementTransactionsRequest(), ?array $options = null): Pager
    {
        $response = $this->_listTransactions($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to retrieve information about a transaction.
     *
     * **Note:** To retrieve a transaction, you need its transactionId. If you don't have the transactionId, use our [List Transactions](https://docs.payroc.com/api/schema/reporting/settlement/list-transactions) method to search for the transaction.
     *
     * Our gateway returns the following information about the transaction:
     *
     * -	Merchant and processing account that ran the transaction.
     * -	Transaction type, date, amount, and the payment method that the customer used.
     * -	Batch that contains the transaction, and authorization details for the transaction.
     * -	Processor that settled the transaction and the ACH deposit containing the transaction.
     *
     * @param int $transactionId Unique identifier of the transaction.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Transaction
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieveTransaction(int $transactionId, ?array $options = null): Transaction
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "transactions/{$transactionId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Transaction::fromJson($json);
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
     * Use this method to retrieve a [paginated](https://docs.payroc.com/api/pagination) list of authorizations.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for authorizations linked to a specific merchant.
     *
     * > **Important:** You must provide a value for either the date query parameter or the batchId query parameter.
     *
     * Our gateway returns the following information about each authorization in the list:
     * - Authorization response from the issuing bank.
     * - Amount that the issuing bank authorized.
     * - Merchant that ran the authorization.
     * - Details about the customer's card, the transaction, and the batch.
     *
     * @param ListReportingSettlementAuthorizationsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Authorization>
     */
    public function listAuthorizations(ListReportingSettlementAuthorizationsRequest $request = new ListReportingSettlementAuthorizationsRequest(), ?array $options = null): Pager
    {
        $response = $this->_listAuthorizations($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to retrieve information about an authorization.
     *
     * **Note:** To retrieve an authorization, you need its authorizationId. If you don't have the authorizationId, use our [List Authorizations](https://docs.payroc.com/api/schema/reporting/settlement/list-authorizations) method to search for the authorization.
     *
     * Our gateway returns the following information about the authorization:
     * - Authorization response from the issuing bank.
     * - Amount that the issuing bank authorized.
     * - Merchant that ran the authorization.
     * - Details about the customer's card, the transaction, and the batch.
     *
     * @param int $authorizationId Unique identifier of the authorization.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Authorization
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieveAuthorization(int $authorizationId, ?array $options = null): Authorization
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "authorizations/{$authorizationId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Authorization::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of disputes.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for disputes linked to a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each dispute in the list:
     * - Its status, type, and description.
     * - Transaction that the dispute is linked to, including the transaction date, merchant who ran the transaction, and the payment method that the cardholder used.
     *
     * @param ListReportingSettlementDisputesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<Dispute>
     */
    public function listDisputes(ListReportingSettlementDisputesRequest $request, ?array $options = null): Pager
    {
        $response = $this->_listDisputes($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to return the status history of a dispute.
     *
     * To view the status history of a dispute, you need its disputeId. If you don't have the disputeId, use our [List Disputes](https://docs.payroc.com/api/schema/reporting/settlement/list-disputes) method to search for the dispute.
     *
     * Our gateway returns a list that contains each status change, the date it was changed, and its updated status.
     *
     * @param int $disputeId Unique identifier of the dispute.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<DisputeStatus>
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function listDisputesStatuses(int $disputeId, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "disputes/{$disputeId}/statuses",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [DisputeStatus::class]); // @phpstan-ignore-line
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of ACH deposits that we paid to your merchants.
     *
     * **Note:** If you want to view the details of a specific ACH deposit and you have its achDepositId, use our [Retrieve ACH Deposit](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-ach-deposit) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for ACH deposits that we paid to a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each ACH deposit in the list:
     * - Merchant that we sent the ACH deposit to.
     * - Total amount that we paid the merchant.
     * - Breakdown of sales, returns, and fees.
     *
     * @param ListReportingSettlementAchDepositsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<AchDeposit>
     */
    public function listAchDeposits(ListReportingSettlementAchDepositsRequest $request, ?array $options = null): Pager
    {
        $response = $this->_listAchDeposits($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to retrieve information about an ACH deposit that we paid to a merchant.
     *
     * **Note:** To retrieve an ACH deposit, you need its achDepositId. If you don't have the achDepositId, use our [List ACH Deposits](https://docs.payroc.com/api/schema/reporting/settlement/list-ach-deposits) method to search for the ACH deposit.
     *
     * Our gateway returns the following information about the ACH deposit:
     *
     * - Merchant that we sent the ACH deposit to.
     * - Total amount that we paid the merchant.
     * - Breakdown of sales, returns, and fees.
     *
     * @param int $achDepositId Unique identifier of the ACH deposit.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return AchDeposit
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieveAchDeposit(int $achDepositId, ?array $options = null): AchDeposit
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "ach-deposits/{$achDepositId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return AchDeposit::fromJson($json);
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
     * Retrieve a list of ACH deposit fees.
     *
     * > **Important:** You must provide a value for either the 'date' query parameter or the 'achDepositId' query parameter.
     *
     * @param ListReportingSettlementAchDepositFeesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<AchDepositFee>
     */
    public function listAchDepositFees(ListReportingSettlementAchDepositFeesRequest $request = new ListReportingSettlementAchDepositFeesRequest(), ?array $options = null): Pager
    {
        $response = $this->_listAchDepositFees($request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of batches that your merchants submitted to the processor on a specific date.
     *
     * **Note:** If you want to view the details of a specific batch and you have its batchId, use our [Retrieve Batch](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-batch) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for batches that were submitted by a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each batch in the list:
     * -	Transaction information, including the number of transactions and total value of sales.
     * -	Merchant information, including the merchant ID (MID) and the processing account that the batch is associated with.
     *
     * @param ListReportingSettlementBatchesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListBatchesSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listBatches(ListReportingSettlementBatchesRequest $request, ?array $options = null): ListBatchesSettlementResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['date'] = JsonSerializer::serializeDate($request->date);
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
                    path: "batches",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListBatchesSettlementResponse::fromJson($json);
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
     * Use this method to return a paginated list of your merchants’ transactions.
     *
     * **Note:** If you want to view the details of a specific transaction and you have its transactionId, use our [Retrieve Transaction](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-transaction) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for transactions for a specific merchant.
     *
     * > **Important:** You must provide a value for either the date query parameter or the batchId query parameter.
     *
     * Our gateway returns the following information about each transaction in the list:
     *
     * -	Merchant and processing account that ran the transaction.
     * -	Transaction type, date, amount, and the payment method that the customer used.
     * -	Batch that contains the transaction, and authorization details for the transaction.
     * -	Processor that settled the transaction and the ACH deposit containing the transaction.
     *
     * @param ListReportingSettlementTransactionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListTransactionsSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listTransactions(ListReportingSettlementTransactionsRequest $request = new ListReportingSettlementTransactionsRequest(), ?array $options = null): ListTransactionsSettlementResponse
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
        if ($request->date != null) {
            $query['date'] = JsonSerializer::serializeDate($request->date);
        }
        if ($request->batchId != null) {
            $query['batchId'] = $request->batchId;
        }
        if ($request->merchantId != null) {
            $query['merchantId'] = $request->merchantId;
        }
        if ($request->transactionType != null) {
            $query['transactionType'] = $request->transactionType;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "transactions",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListTransactionsSettlementResponse::fromJson($json);
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
     * Use this method to retrieve a [paginated](https://docs.payroc.com/api/pagination) list of authorizations.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for authorizations linked to a specific merchant.
     *
     * > **Important:** You must provide a value for either the date query parameter or the batchId query parameter.
     *
     * Our gateway returns the following information about each authorization in the list:
     * - Authorization response from the issuing bank.
     * - Amount that the issuing bank authorized.
     * - Merchant that ran the authorization.
     * - Details about the customer's card, the transaction, and the batch.
     *
     * @param ListReportingSettlementAuthorizationsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListAuthorizationsSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listAuthorizations(ListReportingSettlementAuthorizationsRequest $request = new ListReportingSettlementAuthorizationsRequest(), ?array $options = null): ListAuthorizationsSettlementResponse
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
        if ($request->date != null) {
            $query['date'] = JsonSerializer::serializeDate($request->date);
        }
        if ($request->batchId != null) {
            $query['batchId'] = $request->batchId;
        }
        if ($request->merchantId != null) {
            $query['merchantId'] = $request->merchantId;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "authorizations",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListAuthorizationsSettlementResponse::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of disputes.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for disputes linked to a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each dispute in the list:
     * - Its status, type, and description.
     * - Transaction that the dispute is linked to, including the transaction date, merchant who ran the transaction, and the payment method that the cardholder used.
     *
     * @param ListReportingSettlementDisputesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListDisputesSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listDisputes(ListReportingSettlementDisputesRequest $request, ?array $options = null): ListDisputesSettlementResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['date'] = JsonSerializer::serializeDate($request->date);
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
                    path: "disputes",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListDisputesSettlementResponse::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of ACH deposits that we paid to your merchants.
     *
     * **Note:** If you want to view the details of a specific ACH deposit and you have its achDepositId, use our [Retrieve ACH Deposit](https://docs.payroc.com/api/schema/reporting/settlement/retrieve-ach-deposit) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for ACH deposits that we paid to a specific merchant.
     *
     * > **Important:** You must provide a value for the date query parameter.
     *
     * Our gateway returns the following information about each ACH deposit in the list:
     * - Merchant that we sent the ACH deposit to.
     * - Total amount that we paid the merchant.
     * - Breakdown of sales, returns, and fees.
     *
     * @param ListReportingSettlementAchDepositsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListAchDepositsSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listAchDeposits(ListReportingSettlementAchDepositsRequest $request, ?array $options = null): ListAchDepositsSettlementResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        $query['date'] = JsonSerializer::serializeDate($request->date);
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
                    path: "ach-deposits",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListAchDepositsSettlementResponse::fromJson($json);
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
     * Retrieve a list of ACH deposit fees.
     *
     * > **Important:** You must provide a value for either the 'date' query parameter or the 'achDepositId' query parameter.
     *
     * @param ListReportingSettlementAchDepositFeesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListAchDepositFeesSettlementResponse
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _listAchDepositFees(ListReportingSettlementAchDepositFeesRequest $request = new ListReportingSettlementAchDepositFeesRequest(), ?array $options = null): ListAchDepositFeesSettlementResponse
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
        if ($request->date != null) {
            $query['date'] = JsonSerializer::serializeDate($request->date);
        }
        if ($request->achDepositId != null) {
            $query['achDepositId'] = $request->achDepositId;
        }
        if ($request->merchantId != null) {
            $query['merchantId'] = $request->merchantId;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "ach-deposit-fees",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListAchDepositFeesSettlementResponse::fromJson($json);
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
