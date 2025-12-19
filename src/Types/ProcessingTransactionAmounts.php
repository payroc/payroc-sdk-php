<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about transaction amounts for the processing account.
 */
class ProcessingTransactionAmounts extends JsonSerializableType
{
    /**
     * @var int $average Estimated average transaction amount. The value is in the currency's lowest denomination, for example, cents. You must provide an amount that is greater than zero.
     */
    #[JsonProperty('average')]
    public int $average;

    /**
     * @var int $highest Estimated maximum transaction amount. The value is in the currency's lowest denomination, for example, cents. You must provide an amount that is greater than zero.
     */
    #[JsonProperty('highest')]
    public int $highest;

    /**
     * @param array{
     *   average: int,
     *   highest: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->average = $values['average'];
        $this->highest = $values['highest'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
