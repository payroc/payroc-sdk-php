<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Contains the pagination properties that you use to navigate through a list of results.
 */
class PaginatedList extends JsonSerializableType
{
    /**
     * @var ?float $limit Maximum number of results that we return for each page.
     */
    #[JsonProperty('limit')]
    public ?float $limit;

    /**
     * Number of results we returned on this page.
     *
     * **Note:** This might not be the total number of results that match your query.
     *
     * @var ?float $count
     */
    #[JsonProperty('count')]
    public ?float $count;

    /**
     * @var ?bool $hasMore Indicates whether there is another page of results available.
     */
    #[JsonProperty('hasMore')]
    public ?bool $hasMore;

    /**
     * @var ?array<Link> $links Reference links to navigate to the previous page of results or to the next page of results.
     */
    #[JsonProperty('links'), ArrayType([Link::class])]
    public ?array $links;

    /**
     * @param array{
     *   limit?: ?float,
     *   count?: ?float,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->count = $values['count'] ?? null;
        $this->hasMore = $values['hasMore'] ?? null;
        $this->links = $values['links'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
