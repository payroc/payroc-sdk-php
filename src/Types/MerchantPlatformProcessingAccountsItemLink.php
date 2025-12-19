<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains HATEOAS links for the processing account.
 */
class MerchantPlatformProcessingAccountsItemLink extends JsonSerializableType
{
    /**
     * @var ?string $rel Relationship to the parent resource.
     */
    #[JsonProperty('rel')]
    public ?string $rel;

    /**
     * @var ?string $href Link to the resource.
     */
    #[JsonProperty('href')]
    public ?string $href;

    /**
     * @var ?string $method HTTP method you can use to retrieve the resource.
     */
    #[JsonProperty('method')]
    public ?string $method;

    /**
     * @param array{
     *   rel?: ?string,
     *   href?: ?string,
     *   method?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->rel = $values['rel'] ?? null;
        $this->href = $values['href'] ?? null;
        $this->method = $values['method'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
