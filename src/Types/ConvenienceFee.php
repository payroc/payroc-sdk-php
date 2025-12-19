<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the convenience fee for the transaction.
 */
class ConvenienceFee extends JsonSerializableType
{
    /**
     * If the merchant added a convenience fee, this value indicates the amount of the convenience fee
     * in the currency’s lowest denomination, for example, cents.
     *
     * @var int $amount
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @param array{
     *   amount: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->amount = $values['amount'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
