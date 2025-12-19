<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class PricingTemplate extends JsonSerializableType
{
    /**
     * @var string $pricingIntentId Unique identifier of the pricing intent.
     */
    #[JsonProperty('pricingIntentId')]
    public string $pricingIntentId;

    /**
     * @param array{
     *   pricingIntentId: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->pricingIntentId = $values['pricingIntentId'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
