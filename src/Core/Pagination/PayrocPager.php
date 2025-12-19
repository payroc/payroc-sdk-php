<?php

namespace Payroc\Core\Pagination;

use Generator;
use ReflectionObject;
use Payroc\Core\Client\RawClient;
use Payroc\Core\Client\HttpMethod;
use Payroc\Core\Json\JsonApiRequest;

/**
 * PayrocPager wraps a paginated response and provides navigation methods.
 *
 * This is used for custom pagination endpoints where the pagination pattern
 * uses HATEOAS links for navigation.
 *
 * The response object is expected to have:
 * - `$data` property containing the array of items
 * - `$hasMore` property indicating if there are more pages
 * - `$links` property containing Link objects with `rel`, `method`, and `href`
 *
 * @template TResponse of object
 * @template TItem
 * @extends Pager<TItem>
 */
class PayrocPager extends Pager
{
    /** @var TResponse */
    private object $response;

    private RawClient $rawClient;

    /** @var class-string<TResponse> */
    private string $responseClass;

    /**
     * Creates a new custom pager with the given initial response and client.
     *
     * @param TResponse $response The initial page response
     * @param object $client The client instance (domain client with a private $client property)
     */
    public function __construct(
        object $response,
        object $client
    ) {
        $this->response = $response;
        $this->rawClient = $this->extractRawClient($client);
        /** @var class-string<TResponse> $responseClass */
        $responseClass = get_class($response);
        $this->responseClass = $responseClass;
    }

    /**
     * Extracts the RawClient from a domain client using reflection.
     */
    private function extractRawClient(object $client): RawClient
    {
        if ($client instanceof RawClient) {
            return $client;
        }

        $reflection = new ReflectionObject($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        /** @var RawClient $rawClient */
        $rawClient = $property->getValue($client);
        return $rawClient;
    }

    /**
     * Gets the current response.
     *
     * @return TResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Returns true if there is a next page available.
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        /** @var object $response */
        $response = $this->response;
        // @phpstan-ignore-next-line - TResponse has dynamic properties
        if (!property_exists($response, 'hasMore') || $this->response->hasMore !== true) {
            return false;
        }

        return $this->findLinkHref('next') !== null;
    }

    /**
     * Returns true if there is a previous page available.
     *
     * @return bool
     */
    public function hasPrevPage(): bool
    {
        return $this->findLinkHref('previous') !== null;
    }

    /**
     * Fetches the next page of results and updates the current response.
     *
     * @return TResponse|null The next page response, or null if not available
     */
    public function nextPage()
    {
        $href = $this->findLinkHref('next');
        if ($href === null) {
            return null;
        }

        $this->response = $this->fetchPage($href);
        return $this->response;
    }

    /**
     * Fetches the previous page of results and updates the current response.
     *
     * @return TResponse|null The previous page response, or null if not available
     */
    public function prevPage()
    {
        $href = $this->findLinkHref('previous');
        if ($href === null) {
            return null;
        }

        $this->response = $this->fetchPage($href);
        return $this->response;
    }

    /**
     * Enumerate the values a Page at a time. This may make multiple service requests.
     *
     * @return Generator<int, Page<TItem>>
     */
    public function getPages(): Generator
    {
        do {
            $items = $this->getItemsFromResponse($this->response);
            yield new Page($items);

            if (!$this->hasNextPage()) {
                break;
            }

            $this->nextPage();
        } while (true);
    }

    /**
     * Iterates over each page, calling the provided callback for each page response.
     *
     * @param callable $callback The callback to call for each page
     * @return void
     */
    public function eachPage(callable $callback): void
    {
        do {
            $callback($this->response);

            if (!$this->hasNextPage()) {
                break;
            }

            $this->nextPage();
        } while (true);
    }

    /**
     * Fetches a page by its full URL.
     *
     * @param string $url The full URL to fetch
     * @return TResponse The response object
     */
    private function fetchPage(string $url)
    {
        // Parse the URL to extract base and path
        $parsedUrl = parse_url($url);
        $baseUrl = ($parsedUrl['scheme'] ?? 'https') . '://' . ($parsedUrl['host'] ?? '');
        $path = $parsedUrl['path'] ?? '';
        /** @var array<string, mixed> $query */
        $query = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
        }

        $response = $this->rawClient->sendRequest(
            new JsonApiRequest(
                baseUrl: $baseUrl,
                path: $path,
                method: HttpMethod::GET,
                // @phpstan-ignore-next-line - query params from parse_str
                query: $query,
            ),
        );

        $json = $response->getBody()->getContents();
        // @phpstan-ignore-next-line - TResponse implements fromJson via JsonSerializableType
        return ($this->responseClass)::fromJson($json);
    }

    /**
     * Finds a link href by its rel attribute.
     *
     * @param string $rel The relationship type to find (e.g., 'next', 'prev')
     * @return string|null The href if found, null otherwise
     */
    private function findLinkHref(string $rel): ?string
    {
        /** @var object $response */
        $response = $this->response;
        // @phpstan-ignore-next-line - TResponse has dynamic properties
        if (!property_exists($response, 'links') || $this->response->links === null) {
            return null;
        }

        // @phpstan-ignore-next-line - TResponse has dynamic properties
        foreach ($this->response->links as $link) {
            /** @var object $link */
            if (property_exists($link, 'rel') && $link->rel === $rel) {
                return $link->href ?? null;
            }
        }

        return null;
    }

    /**
     * Extracts items from a response object.
     *
     * @param TResponse $response The response object
     * @return array<TItem>
     */
    private function getItemsFromResponse(object $response): array
    {
        /** @var object $resp */
        $resp = $response;
        // @phpstan-ignore-next-line - TResponse has dynamic properties
        if (property_exists($resp, 'data') && is_array($response->data)) {
            return $response->data;
        }

        return [];
    }
}
