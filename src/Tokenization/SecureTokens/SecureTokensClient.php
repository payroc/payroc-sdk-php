<?php

namespace Payroc\Tokenization\SecureTokens;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Tokenization\SecureTokens\Requests\ListSecureTokensRequest;
use Payroc\Core\Pagination\Pager;
use Payroc\Types\SecureTokenWithAccountType;
use Payroc\Core\Pagination\PayrocPager;
use Payroc\Tokenization\SecureTokens\Requests\TokenizationRequest;
use Payroc\Types\SecureToken;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Tokenization\SecureTokens\Requests\PartiallyUpdateSecureTokensRequest;
use Payroc\Tokenization\SecureTokens\Requests\UpdateAccountSecureTokensRequest;
use Payroc\Types\SecureTokenPaginatedListWithAccountType;

class SecureTokensClient
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of secure tokens.
     *
     * **Note:** If you want to view the details of a specific secure token and you have its secureTokenId, use our [Retrieve Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for secure tokens by customer or by the first four digits of a card number.
     *
     * Our gateway returns information about the following for each secure token in the list:
     *
     *   -	Payment details that the secure token represents.
     *   -	Customer details, including shipping and billing addresses.
     *   -	Secure token that you can use to carry out transactions.
     *
     *   For each secure token, we also return the secureTokenId, which you can use to perform follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListSecureTokensRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Pager<SecureTokenWithAccountType>
     */
    public function list(string $processingTerminalId, ListSecureTokensRequest $request = new ListSecureTokensRequest(), ?array $options = null): Pager
    {
        $response = $this->_list($processingTerminalId, $request, $options);
        return new PayrocPager(response: $response, client: $this);
    }

    /**
     * Use this method to create a secure token that represents a customer's payment details.
     *
     * When you create a secure token, you need to generate and provide a secureTokenId that you use to run follow-on actions:
     * - [Retrieve Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/retrieve) – View the details of the secure token.
     * - [Delete Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/delete) – Delete the secure token.
     * - [Update Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/partially-update) – Update the details of the secure token.
     * - [Update Account Details](https://docs.payroc.com/api/schema/tokenization/secure-tokens/update-account) – Update the secure token with the details from a single-use token.
     *
     * **Note:** If you don't generate a secureTokenId to identify the token, our gateway generates a unique identifier and returns it in the response.
     *
     * If the request is successful, our gateway returns a token that the merchant can use in transactions instead of the customer's sensitive payment details, for example, when they [run a sale](https://docs.payroc.com/api/schema/card-payments/payments/create).
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param TokenizationRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SecureToken
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function create(string $processingTerminalId, TokenizationRequest $request, ?array $options = null): SecureToken
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SecureToken::fromJson($json);
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
     * Use this method to retrieve information about a secure token.
     *
     * To retrieve a secure token, you need its secureTokenID, which you sent in the request of the [Create Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/create) method.
     *
     * **Note:** If you don't have the secureTokenId, use our [List Secure Tokens](https://docs.payroc.com/api/schema/tokenization/secure-tokens/list) method to search for the secure token.
     *
     * Our gateway returns the following information about the secure token:
     *
     *   -	Payment details that the secure token represents.
     *   -	Customer details, including shipping and billing addresses.
     *   -	Secure token that you can use to carry out transactions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $secureTokenId Unique identifier that the merchant assigned to the secure token.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SecureTokenWithAccountType
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $processingTerminalId, string $secureTokenId, ?array $options = null): SecureTokenWithAccountType
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens/{$secureTokenId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SecureTokenWithAccountType::fromJson($json);
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
     * Use this method to delete a secure token and its related payment details from our vault.
     *
     * To delete a secure token, you need its secureTokenId, which you sent in the request of the [Create Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/create) method.
     *
     * **Note:** If you don’t have the secureTokenId, use our [List Secure Tokens](https://docs.payroc.com/api/schema/tokenization/secure-tokens/list) method to search for the secure token.
     *
     * When you delete a secure token, you can’t recover it, and you can’t reuse its identifier for a new token.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $secureTokenId Unique identifier that the merchant assigned to the secure token.
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
    public function delete(string $processingTerminalId, string $secureTokenId, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens/{$secureTokenId}",
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
     * Use this method to partially update a secure token. Structure your request to follow the [RFC 6902](https://datatracker.ietf.org/doc/html/rfc6902) standard.
     *
     * To update a secure token, you need its secureTokenId, which you sent in the request of the [Create Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/create) method.
     *
     * **Note:** If you don't have the secureTokenId, use our [List Secure Tokens](https://docs.payroc.com/api/schema/tokenization/secure-tokens/list) method to search  for the payment.
     *
     * You can update all of the properties of the secure token, except the following:
     * - processingTerminalId
     * - type
     * - token
     * - status
     * - source/Card
     *   - type
     *   - cardNumber
     *   - cardType
     *   - currency
     *   - debit
     *   - surcharging
     * - source/ACH account
     *   - accountNumber
     *   - routingNumber
     * - source/PAD account
     *   - type
     *   - accountNumber
     *   - transitNumber
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $secureTokenId Unique identifier that the merchant assigned to the secure token.
     * @param PartiallyUpdateSecureTokensRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SecureToken
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function partiallyUpdate(string $processingTerminalId, string $secureTokenId, PartiallyUpdateSecureTokensRequest $request, ?array $options = null): SecureToken
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens/{$secureTokenId}",
                    method: HttpMethod::PATCH,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SecureToken::fromJson($json);
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
     * Use this method to update a secure token if you have a single-use token from Hosted Fields.
     *
     * **Note:** If you don't have a single-use token, you can update saved payment details with our [Update Secure Token](https://docs.payroc.com/api/resources#updateSecureToken) method. For more information about our two options to update a secure token, go to [Update saved payment details](https://docs.payroc.com/guides/integrate/update-saved-payment-details).
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param string $secureTokenId Unique identifier that the merchant assigned to the secure token.
     * @param UpdateAccountSecureTokensRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SecureToken
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function updateAccount(string $processingTerminalId, string $secureTokenId, UpdateAccountSecureTokensRequest $request, ?array $options = null): SecureToken
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens/{$secureTokenId}/update-account",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $request->body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SecureToken::fromJson($json);
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
     * Use this method to return a [paginated](https://docs.payroc.com/api/pagination) list of secure tokens.
     *
     * **Note:** If you want to view the details of a specific secure token and you have its secureTokenId, use our [Retrieve Secure Token](https://docs.payroc.com/api/schema/tokenization/secure-tokens/retrieve) method.
     *
     * Use query parameters to filter the list of results that we return, for example, to search for secure tokens by customer or by the first four digits of a card number.
     *
     * Our gateway returns information about the following for each secure token in the list:
     *
     *   -	Payment details that the secure token represents.
     *   -	Customer details, including shipping and billing addresses.
     *   -	Secure token that you can use to carry out transactions.
     *
     *   For each secure token, we also return the secureTokenId, which you can use to perform follow-on actions.
     *
     * @param string $processingTerminalId Unique identifier that we assigned to the terminal.
     * @param ListSecureTokensRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SecureTokenPaginatedListWithAccountType
     * @throws PayrocException
     * @throws PayrocApiException
     */
    private function _list(string $processingTerminalId, ListSecureTokensRequest $request = new ListSecureTokensRequest(), ?array $options = null): SecureTokenPaginatedListWithAccountType
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->secureTokenId != null) {
            $query['secureTokenId'] = $request->secureTokenId;
        }
        if ($request->customerName != null) {
            $query['customerName'] = $request->customerName;
        }
        if ($request->phone != null) {
            $query['phone'] = $request->phone;
        }
        if ($request->email != null) {
            $query['email'] = $request->email;
        }
        if ($request->token != null) {
            $query['token'] = $request->token;
        }
        if ($request->first6 != null) {
            $query['first6'] = $request->first6;
        }
        if ($request->last4 != null) {
            $query['last4'] = $request->last4;
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
                    path: "processing-terminals/{$processingTerminalId}/secure-tokens",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SecureTokenPaginatedListWithAccountType::fromJson($json);
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
