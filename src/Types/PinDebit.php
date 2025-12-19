<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the fees for PIN-debit transactions.
 */
class PinDebit extends JsonSerializableType
{
    /**
     * @var float $additionalDiscount Percentage of additional discount.
     */
    #[JsonProperty('additionalDiscount')]
    public float $additionalDiscount;

    /**
     * @var int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public int $transaction;

    /**
     * @var int $monthlyAccess Monthly access fee for using PIN-debit services. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlyAccess')]
    public int $monthlyAccess;

    /**
     * @param array{
     *   additionalDiscount: float,
     *   transaction: int,
     *   monthlyAccess: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->additionalDiscount = $values['additionalDiscount'];
        $this->transaction = $values['transaction'];
        $this->monthlyAccess = $values['monthlyAccess'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
