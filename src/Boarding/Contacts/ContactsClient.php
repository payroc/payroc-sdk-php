<?php

namespace Payroc\Boarding\Contacts;

use GuzzleHttp\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Types\Contact;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Json\JsonApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Boarding\Contacts\Requests\UpdateContactsRequest;

class ContactsClient
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
     * Use this method to retrieve details about a contact.
     *
     * To retrieve a contact, you need its contactId. Our gateway returned the contactId in the [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don't have the contactId, use the [List Contacts](https://docs.payroc.com/api/schema/boarding/processing-accounts/list-contacts) method to search for the contact.
     *
     * Our gateway returns the following information about a contact:
     *
     * -	Name and contact method, including their phone number or mobile number.
     * -	Role within the business, for example, if they are a manager.
     *
     * @param int $contactId Unique identifier for the contact.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return Contact
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(int $contactId, ?array $options = null): Contact
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "contacts/{$contactId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return Contact::fromJson($json);
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
     * Use this method to update a contact of a processing account.
     *
     * To update a contact, you need its contactId. Our gateway returned the contactId in the response of the [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don't have the contactId, use our [List Contacts](https://docs.payroc.com/api/schema/boarding/processing-accounts/list-contacts) method to search for the contact.
     *
     * You can update the following details about a contact:
     *
     * -	First name and last name.
     * -	Contact details, including their phone number or mobile number.
     * -	Identification details, including their identification type and number.
     * -	Role within the business, for example, if they are a manager.
     *
     * @param int $contactId Unique identifier for the contact.
     * @param UpdateContactsRequest $request
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
    public function update(int $contactId, UpdateContactsRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "contacts/{$contactId}",
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
     * Use this method to delete a contact associated with a processing account.
     *
     * To delete a contact, you need their contactId. Our gateway returned the contactId in the response of the [Create Processing Account](https://docs.payroc.com/api/schema/boarding/merchant-platforms/create-processing-account) method.
     *
     * **Note:** If you don’t have the contactId, use our [Retrieve Processing Account](https://docs.payroc.com/api/schema/boarding/processing-accounts/retrieve) method or our [List Contacts](https://docs.payroc.com/api/schema/boarding/processing-accounts/list-contacts) method to search for the contact.
     *
     * @param int $contactId Unique identifier for the contact.
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
    public function delete(int $contactId, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "contacts/{$contactId}",
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
}
