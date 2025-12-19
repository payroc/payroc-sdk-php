<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the transaction.
 */
class BankTransferBreakdownBase extends JsonSerializableType
{
    /**
     * @var int $subtotal Total amount of the transaction before tax and tip. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?Tip $tip Object that contains tip information for the transaction.
     */
    #[JsonProperty('tip')]
    public ?Tip $tip;

    /**
     * @param array{
     *   subtotal: int,
     *   tip?: ?Tip,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->tip = $values['tip'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
