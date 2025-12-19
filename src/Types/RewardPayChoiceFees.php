<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class RewardPayChoiceFees extends JsonSerializableType
{
    /**
     * @var int $monthlySubscription Fee for the monthly subscription for the processing plan. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlySubscription')]
    public int $monthlySubscription;

    /**
     * @var RewardPayChoiceFeesDebit $debit Object that contains information about fees for debit transactions.
     */
    #[JsonProperty('debit')]
    public RewardPayChoiceFeesDebit $debit;

    /**
     * @var RewardPayChoiceFeesCredit $credit Object that contains information about fees for credit transactions.
     */
    #[JsonProperty('credit')]
    public RewardPayChoiceFeesCredit $credit;

    /**
     * @var ?SpecialityCards $specialityCards
     */
    #[JsonProperty('specialityCards')]
    public ?SpecialityCards $specialityCards;

    /**
     * @param array{
     *   monthlySubscription: int,
     *   debit: RewardPayChoiceFeesDebit,
     *   credit: RewardPayChoiceFeesCredit,
     *   specialityCards?: ?SpecialityCards,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->monthlySubscription = $values['monthlySubscription'];
        $this->debit = $values['debit'];
        $this->credit = $values['credit'];
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
