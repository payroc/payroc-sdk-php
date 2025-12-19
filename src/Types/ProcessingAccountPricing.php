<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that HATEOAS links to the pricing information that we apply to the processing account.
 */
class ProcessingAccountPricing extends JsonSerializableType
{
    /**
     * @var ?ProcessingAccountPricingLink $link Object that contains HATEOAS links to the pricing information for the processing account.
     */
    #[JsonProperty('link')]
    public ?ProcessingAccountPricingLink $link;

    /**
     * @param array{
     *   link?: ?ProcessingAccountPricingLink,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
