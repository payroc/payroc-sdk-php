<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the fees for EBT transactions.
 */
class ElectronicBenefitsTransfer extends JsonSerializableType
{
    /**
     * @var int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public int $transaction;

    /**
     * @param array{
     *   transaction: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
