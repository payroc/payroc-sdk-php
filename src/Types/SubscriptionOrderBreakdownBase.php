<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class SubscriptionOrderBreakdownBase extends JsonSerializableType
{
    /**
     * @var int $subtotal Total amount for the transaction before tax. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?ConvenienceFee $convenienceFee
     */
    #[JsonProperty('convenienceFee')]
    public ?ConvenienceFee $convenienceFee;

    /**
     * @param array{
     *   subtotal: int,
     *   convenienceFee?: ?ConvenienceFee,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->convenienceFee = $values['convenienceFee'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
