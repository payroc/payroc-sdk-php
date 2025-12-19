<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the taxes that apply to the transaction.
 */
class PaymentPlanOrderBreakdownBase extends JsonSerializableType
{
    /**
     * @var int $subtotal Total amount for the transaction before tax. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @param array{
     *   subtotal: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
