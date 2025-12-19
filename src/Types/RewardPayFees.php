<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class RewardPayFees extends JsonSerializableType
{
    /**
     * @var int $monthlySubscription Fee for the monthly subscription for the processing plan. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlySubscription')]
    public int $monthlySubscription;

    /**
     * @var ?float $cardChargePercentage Percentage of the total transaction amount that the processor charges the cardholder.
     */
    #[JsonProperty('cardChargePercentage')]
    public ?float $cardChargePercentage;

    /**
     * @var ?float $merchantChargePercentage Percentage of the total transaction amount that the processor charges the merchant.
     */
    #[JsonProperty('merchantChargePercentage')]
    public ?float $merchantChargePercentage;

    /**
     * @var ?int $transaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('transaction')]
    public ?int $transaction;

    /**
     * @var value-of<RewardPayFeesTips> $tips Indicates how the merchant manages tips.
     */
    #[JsonProperty('tips')]
    public string $tips;

    /**
     * @var ?SpecialityCards $specialityCards
     */
    #[JsonProperty('specialityCards')]
    public ?SpecialityCards $specialityCards;

    /**
     * @param array{
     *   monthlySubscription: int,
     *   tips: value-of<RewardPayFeesTips>,
     *   cardChargePercentage?: ?float,
     *   merchantChargePercentage?: ?float,
     *   transaction?: ?int,
     *   specialityCards?: ?SpecialityCards,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->monthlySubscription = $values['monthlySubscription'];
        $this->cardChargePercentage = $values['cardChargePercentage'] ?? null;
        $this->merchantChargePercentage = $values['merchantChargePercentage'] ?? null;
        $this->transaction = $values['transaction'] ?? null;
        $this->tips = $values['tips'];
        $this->specialityCards = $values['specialityCards'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
