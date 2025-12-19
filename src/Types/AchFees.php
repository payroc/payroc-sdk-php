<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains processing fees for ACH transactions.
 */
class AchFees extends JsonSerializableType
{
    /**
     * @var int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public int $transaction;

    /**
     * @var int $batch Fee for each batch. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('batch')]
    public int $batch;

    /**
     * @var int $returns Fee for each return. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('returns')]
    public int $returns;

    /**
     * @var int $unauthorizedReturn Fee for each unauthorized return. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('unauthorizedReturn')]
    public int $unauthorizedReturn;

    /**
     * @var int $statement Fee for each statement. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('statement')]
    public int $statement;

    /**
     * @var int $monthlyMinimum Minimum monthly value of transactions. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlyMinimum')]
    public int $monthlyMinimum;

    /**
     * @var int $accountVerification Fee for each account verification. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('accountVerification')]
    public int $accountVerification;

    /**
     * @var float $discountRateUnder10000 Percentage discount for ACH transfers less than $10,000.
     */
    #[JsonProperty('discountRateUnder10000')]
    public float $discountRateUnder10000;

    /**
     * @var float $discountRateAbove10000 Percentage discount for ACH transfers equal to or more than $10,000.
     */
    #[JsonProperty('discountRateAbove10000')]
    public float $discountRateAbove10000;

    /**
     * @param array{
     *   transaction: int,
     *   batch: int,
     *   returns: int,
     *   unauthorizedReturn: int,
     *   statement: int,
     *   monthlyMinimum: int,
     *   accountVerification: int,
     *   discountRateUnder10000: float,
     *   discountRateAbove10000: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->transaction = $values['transaction'];
        $this->batch = $values['batch'];
        $this->returns = $values['returns'];
        $this->unauthorizedReturn = $values['unauthorizedReturn'];
        $this->statement = $values['statement'];
        $this->monthlyMinimum = $values['monthlyMinimum'];
        $this->accountVerification = $values['accountVerification'];
        $this->discountRateUnder10000 = $values['discountRateUnder10000'];
        $this->discountRateAbove10000 = $values['discountRateAbove10000'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
