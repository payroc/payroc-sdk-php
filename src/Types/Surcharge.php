<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the surcharge.
 */
class Surcharge extends JsonSerializableType
{
    /**
     * Indicates if the merchant wants to remove the surcharge fee from the transaction.
     * - `true` - Gateway removes the surcharge fee from the transaction.
     * - `false` - Gateway adds the fee to the transaction.
     *
     * @var ?bool $bypass
     */
    #[JsonProperty('bypass')]
    public ?bool $bypass;

    /**
     * If the merchant added a surcharge fee, this value indicates the amount of the surcharge fee
     * in the currency’s lowest denomination, for example, cents.
     *
     * @var ?int $amount
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?float $percentage If the merchant added a surcharge fee, this value indicates the surcharge percentage.
     */
    #[JsonProperty('percentage')]
    public ?float $percentage;

    /**
     * @param array{
     *   bypass?: ?bool,
     *   amount?: ?int,
     *   percentage?: ?float,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->bypass = $values['bypass'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->percentage = $values['percentage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
