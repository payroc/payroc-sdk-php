<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the breakdown of the transaction.
 */
class BreakdownBase extends JsonSerializableType
{
    /**
     * @var int $subtotal Amount of the transaction before tax and fees. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('subtotal')]
    public int $subtotal;

    /**
     * @var ?int $cashbackAmount Amount of cashback for the transaction.
     */
    #[JsonProperty('cashbackAmount')]
    public ?int $cashbackAmount;

    /**
     * @var ?Tip $tip Object that contains tip information for the transaction.
     */
    #[JsonProperty('tip')]
    public ?Tip $tip;

    /**
     * @var ?Surcharge $surcharge Object that contains surcharge information for the transaction.
     */
    #[JsonProperty('surcharge')]
    public ?Surcharge $surcharge;

    /**
     * @var ?DualPricing $dualPricing Object that contains dual pricing information for the transaction.
     */
    #[JsonProperty('dualPricing')]
    public ?DualPricing $dualPricing;

    /**
     * @param array{
     *   subtotal: int,
     *   cashbackAmount?: ?int,
     *   tip?: ?Tip,
     *   surcharge?: ?Surcharge,
     *   dualPricing?: ?DualPricing,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subtotal = $values['subtotal'];
        $this->cashbackAmount = $values['cashbackAmount'] ?? null;
        $this->tip = $values['tip'] ?? null;
        $this->surcharge = $values['surcharge'] ?? null;
        $this->dualPricing = $values['dualPricing'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
