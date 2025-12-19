<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about transaction limits for the processing account.
 */
class ProcessingAchLimits extends JsonSerializableType
{
    /**
     * @var int $singleTransaction Maximum amount allowed for a single debit or credit transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('singleTransaction')]
    public int $singleTransaction;

    /**
     * @var int $dailyDeposit Maximum amount of total transactions allowed per day. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('dailyDeposit')]
    public int $dailyDeposit;

    /**
     * @var int $monthlyDeposit Maximum amount of total transactions allowed per month. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlyDeposit')]
    public int $monthlyDeposit;

    /**
     * @param array{
     *   singleTransaction: int,
     *   dailyDeposit: int,
     *   monthlyDeposit: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->singleTransaction = $values['singleTransaction'];
        $this->dailyDeposit = $values['dailyDeposit'];
        $this->monthlyDeposit = $values['monthlyDeposit'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
