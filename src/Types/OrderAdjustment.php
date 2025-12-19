<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the adjustment to the transaction. Send this object if the merchant is adjusting the order details.
 */
class OrderAdjustment extends JsonSerializableType
{
    /**
     * @var int $amount Total amount of the transaction.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var ?BreakdownAdjustment $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?BreakdownAdjustment $breakdown;

    /**
     * @param array{
     *   amount: int,
     *   breakdown?: ?BreakdownAdjustment,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->amount = $values['amount'];
        $this->breakdown = $values['breakdown'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
