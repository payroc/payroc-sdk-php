<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class InterchangePlusAmexOptBlue extends JsonSerializableType
{
    /**
     * @var float $volume Percentage of the total transaction amount that the processor charges the merchant.
     */
    #[JsonProperty('volume')]
    public float $volume;

    /**
     * @var int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public int $transaction;

    /**
     * @param array{
     *   volume: float,
     *   transaction: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->volume = $values['volume'];
        $this->transaction = $values['transaction'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
