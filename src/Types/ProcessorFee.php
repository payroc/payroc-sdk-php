<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the processor fees.
 */
class ProcessorFee extends JsonSerializableType
{
    /**
     * @var ?float $volume Percentage of total transaction amount that the processor charges the merchant.
     */
    #[JsonProperty('volume')]
    public ?float $volume;

    /**
     * @var ?int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public ?int $transaction;

    /**
     * @param array{
     *   volume?: ?float,
     *   transaction?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->volume = $values['volume'] ?? null;
        $this->transaction = $values['transaction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
