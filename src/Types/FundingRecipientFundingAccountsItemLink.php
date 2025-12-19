<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains HATEOAS links for the resource.
 */
class FundingRecipientFundingAccountsItemLink extends JsonSerializableType
{
    /**
     * @var ?string $rel Indicates the relationship between the current resource and the target resource.
     */
    #[JsonProperty('rel')]
    public ?string $rel;

    /**
     * @var ?string $href URL of the target resource.
     */
    #[JsonProperty('href')]
    public ?string $href;

    /**
     * @var ?string $method HTTP method that you need to use with the target resource.
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
